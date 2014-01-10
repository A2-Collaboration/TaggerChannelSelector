#!/usr/bin/perl
print <<"EOF";
HTTP/1.0 200 OK
Content-type: text/plain

EOF

$req = $ENV{'QUERY_STRING'};
($addr,$val) = split(/=/,$req);
$cmd = "/opt/a2vme/build/bin/vmeext $addr ";
if(defined $val) {
  $cmd .=  "$val w";
}
else {
  $cmd .= "0 r";
}

my $ret = `$cmd`;
if($ret =~ /Pattern = ([[:xdigit:]]+)/) {
  print $1;
}
else{
  print "Unrecognized return string: $ret";
}
