<?php

/**
 * Multimedia
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Multimedia extends BaseMultimedia
{
  public static $allowed_mime_type = array(
    'csv' => 'text/csv',
    'txt' => 'text/plain',
//   'htm' => 'text/html',
    'html' => 'text/html',
//    'php' => 'text/html',
    'css' => 'text/css',
//    'js' => 'application/javascript',
//    'json' => 'application/json',
    'xml' => 'application/xml',
    'xsd' => 'application/xsd',
//    'swf' => 'application/x-shockwave-flash',
//    'flv' => 'video/x-flv',

    // images
    'png' => 'image/png',
//    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'ico' => 'image/vnd.microsoft.icon',
    'tiff' => 'image/tiff',
    'tif' => 'image/tiff',
    'svg' => 'image/svg+xml',
    'ogg' => 'application/ogg',
//    'svgz' => 'image/svg+xml',

    // archives
    'zip' => 'application/zip',
    'rar' => 'application/x-rar-compressed',
//    'exe' => 'application/x-msdownload',
//    'msi' => 'application/x-msdownload',
//    'cab' => 'application/vnd.ms-cab-compressed',
    // audio
    'wav' => 'audio/x-wav',
    'mp3' => 'audio/mpeg',
    'wma' => 'audio/x-ms-wma',
    'rla' => 'audio/vnd.rn-realaudio',
    'flac' => 'audio/flac',
    'aac' => 'audio/aac',
    // video
//    'qt' => 'video/quicktime',
    'mov' => 'video/quicktime',
    'mp4' => 'video/mp4',
    'mpeg' => 'video/mpeg',

    // adobe
    'pdf' => 'application/pdf',
    'psd' => 'image/vnd.adobe.photoshop',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',

    // ms office
    'doc' => 'application/msword',
    'rtf' => 'application/rtf',
    'xls' => 'application/vnd.ms-excel',
    'ppt' => 'application/vnd.ms-powerpoint',

    // open office
    'odt' => 'application/vnd.oasis.opendocument.text',
    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

  public function getCreationDateMasked()
  {
    $dateTime = new FuzzyDateTime($this->_get('creation_date'), $this->_get('creation_date_mask'),false,false);
    return $dateTime->getDateMasked();
  }

  public function getCreationDate()
  {
    $date = new FuzzyDateTime($this->_get('creation_date'),$this->_get('creation_date_mask'),false, false);
    return $date->getDateTime(null, 'Y/m/d', null);
  }

  public function changeUri()
  {
    $this->checkUploadPathAvailable() ;
    rename(
      sfConfig::get('sf_upload_dir')."/multimedia/temp/".$this->_get('uri'),
      sfConfig::get('sf_upload_dir')."/multimedia/".$this->getBuildedUrl()
    );
    $this->setUri($this->getBuildedUrl()) ;
  }

  public function getBuildedUrl()
  {
    return $this->getBuildedDir().'/'. $this->_get('uri');
  }
  public function getBuildedDir()
  {
    //Make something like multimedia/00/01/01/12  for the multimed of id= 10112
    $num = sprintf('%08d', $this->getRecordId());
    return $this->getReferencedRelation().'/'.implode('/',str_split($num,'2'));
  }

  public function move($from){
    $this->checkUploadPathAvailable() ;
    $filename = basename($from);
    $this->setUri($this->getBuildedDir().$filename);
    copy(
      sfConfig::get('sf_upload_dir')."/multimedia/".$from,
      sfConfig::get('sf_upload_dir')."/multimedia/".$this->getUri()
    );
  }

  protected function checkUploadPathAvailable()
  {
    //function used to verify if the folder for the uploaded file exists
    $path = sfConfig::get('sf_upload_dir')."/multimedia/".$this->getBuildedDir();
    if(!is_dir($path)) mkdir($path,0750,true) ;
    return true;
  }

  public static function CheckMimeType($mime_type)
  {
    return(in_array($mime_type,self::$allowed_mime_type)?true:false);
  }

  public function getFullURI()
  {
    return sfConfig::get('sf_upload_dir').'/multimedia/'.$this->getUri();
  }

  public function getSize()
  {
    return filesize($this->getFullURI());
  }

  public function hasPreview()
  {
    return self::canBePreviewed($this->getMimeType());
  }

  public static function canBePreviewed($mime) {
    if(in_array($mime ,array('image/png', 'image/jpeg') ) )
      return true;
    return false;
  }

  public function getPreview($new_w = 200, $new_h = 200)
  {
    if($this->hasPreview())
    {
      $image = new Imagick($this->getFullURI());
      if($this->getMimeType() == 'application/pdf') {
        // Display page 1 of pdfs
        $image->setIteratorIndex(0);
      }
      $image->thumbnailImage( $new_w, $new_h, true );
      $image->setImageFormat( "png" );
      $image->setCompression(Imagick::COMPRESSION_LZW);
      $image->setCompressionQuality(90);
      return $image->getImageBlob();
    }
  }

  public function getHumanSize()
  {

    return $this->HumanReadableFilesize($this->getSize());
  }

  public static function HumanReadableFilesize($size) {
    $mod = 1024;
    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
    return round($size, 2) . ' ' . $units[$i];
  }

  public function save(Doctrine_Connection $conn = null)
  {
    if($this->isNew()) {
      $this->changeUri();
      if($this->getMimeType() == 'application/pdf') {
        $pdf = new PDF2Text();
        $pdf->setFilename($this->getFullURI());
        $content = '';
        try {
          $pdf->decodePDF();
          $content = $pdf->output();
          if ( $content == '' ) {
            // try with different multibyte setting
            $pdf->setUnicode(true);
            $pdf->decodePDF();
            $content = $pdf->output();
          }
        } catch ( Exception $e ) {}
        if($content != '')
          $this->setExtractedInfo($content);
      }
      if($this->getMimeType() == 'text/plain'){
        $content = file_get_contents($this->getFullURI());
        $this->setExtractedInfo($content);
      }
    }
    parent::save($conn);
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    $url = $this->getFullURI();
    parent::delete($conn);
    unlink($url);
  }
  public function getLink()
  {
    return $this->getTable()->getLinkforKnownTable($this->getReferencedRelation(),$this->getRecordId());
  }
}