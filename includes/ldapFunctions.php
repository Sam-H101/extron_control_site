<?php


// returns user first and last name in form givenname[0][0] and givenname[1][0]
function ldapName($LDAPUSER, $LDAPPASS)
{
  $ad = adConnect();
  ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
  if (!@ldap_bind($ad, "{$LDAPUSER}@LYNCHBURG.EDU", $LDAPPASS)){ LogError("Can Not bind to LDAP"); return $false;}
  $attr = array("givenname", "sn");
  $filter = "(sAMAccountName=" . $LDAPUSER . ")";
  $basednldap = 'dc=lynchburg,dc=edu';
  $result = ldap_search($ad, $basednldap, $filter, $attr);
  $entries = ldap_get_entries($ad, $result);
  $givenname = array($entries[0]['givenname'], $entries[0]['sn']);
  ldap_unbind($ad); 
  return $givenname;

}
function baseLdap()
{
  return 'dc=lynchburg,dc=edu';

}


// check to see if user is part of an LDAP group
function checkAuthLDAP($ldapuser, $ldappass, $groupnameldap)
{
  $userldap = $ldapuser;
  $passwordldap = $ldappass;
  $hostldap = 'ymir';
  $domainldap = 'lynchburg.edu';
  $basednldap = baseLdap();
  $groupldap = $groupnameldap;

  $ad = ldap_connect("ldap://{$hostldap}.{$domainldap}") or die('Could not connect to LDAP server.');
  ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
  if (!@ldap_bind($ad, "{$userldap}@{$domainldap}", $passwordldap)){ LogError("Could not bind or login with username $userldap.");return $false;}
  $userdn = getDN($ad, $userldap, $basednldap);
  if (checkGroupEx($ad, $userdn, getDN($ad, $groupldap, $basednldap))) {
    //if (checkGroup($ad, $userdn, getDN($ad, $group, $basedn))) {
      return 1;
    } else {
      return 0;
    }
  ldap_unbind($ad);



}

function adConnect()
{
  $hostldap = 'ymir';
  $domainldap = 'lynchburg.edu';
  $ad = ldap_connect("ldap://{$hostldap}.{$domainldap}") or die('Could not connect to LDAP server.');
  return $ad;
}

function getUserDN($ldapuser, $ldappass)
{
  $userldap = $ldapuser;
  $passwordldap = $ldappass;
  $basednldap = 'dc=lynchburg,dc=edu';


  $ad = adConnect();
  ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
  if (!@ldap_bind($ad, "{$userldap}", $passwordldap))
    {return $false;}
  $userdn = getDN($ad, $userldap, $basednldap);
  return $userdn;



}

function getDN($ad, $samaccountname, $basedn) {
    $attributes = array('dn');
    $result = ldap_search($ad, $basedn,"(samaccountname={$samaccountname})", $attributes);
    if ($result === FALSE) 
    { return ''; }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count']>0)
    
    { return $entries[0]['dn']; }
    else { return ''; }
}

/*
* This function retrieves and returns CN from given DN
*/
function getCN($dn) {
    preg_match('/[^,]*/', $dn, $matchs, PREG_OFFSET_CAPTURE, 3);
    return $matchs[0][0];
}

/*
* This function checks group membership of the user, searching only
* in specified group (not recursively).
*/
function checkGroupAD($ad, $userdn, $groupdn) {
    $attributes = array('members');
    $result = ldap_read($ad, $userdn, "(memberof={$groupdn})", $attributes);
    if ($result == FALSE) { return FALSE; }
    $entries = ldap_get_entries($ad, $result);
    return ($entries['count'] > 0);
}

/*
* This function checks group membership of the user, searching
* in specified group and groups which is its members (recursively).
*/
function checkGroupEx($ad, $userdn, $groupdn) {
    $attributes = array('memberof');
    $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
    if ($result === FALSE) { return FALSE; }
    $entries = ldap_get_entries($ad, $result);
    if ($entries['count'] <= 0) { return FALSE; }
    if (empty($entries[0]['memberof'])) { return FALSE; } else {
        for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
            if ($entries[0]['memberof'][$i] == $groupdn) { return TRUE; }
            elseif (checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn)) { return TRUE; }
        }
    }
    return FALSE;
}








?>