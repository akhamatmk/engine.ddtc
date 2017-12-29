<?php
/** 
 * Password Strength Helper
 * @packages    Helpers
 */
/**
 * Password Rules
 *
 * Check password for complexity and length requirements
 * 
 * @param string $candidate     The password string that the user typed in.
 * @return bool                 True or False according to if passed
 * @category Helpers
 * @access public
 * @package Helpers
 */

function valid_pass($candidate) 
{
   $r1='/[A-Z]/';  //Uppercase
   $r2='/[a-z]/';  //lowercase
   $r3='/[!@#$%&*()^,._;:-]/';  // whatever you mean by 'special char'
   $r4='/[0-9]/';  //numbers

   if(preg_match_all($r1,$candidate, $o)<1) return FALSE;

   if(preg_match_all($r2,$candidate, $o)<1) return FALSE;

   if(preg_match_all($r3,$candidate, $o)<1) return FALSE;

   if(preg_match_all($r4,$candidate, $o)<1) return FALSE;

   return TRUE;
}