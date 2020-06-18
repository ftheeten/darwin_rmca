<?php

/**
 * BaseLoanActors
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Loans $Loans
 * 
 * @method Loans      getLoans() Returns the current record's "Loans" value
 * @method LoanActors setLoans() Sets the current record's "Loans" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLoanActors extends CataloguePeople
{
    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Loans', array(
             'local' => 'record_id',
             'foreign' => 'id'));
    }
}