%skip space \s

// Scalars
%token host host
%token hardware hardware
%token ethernet ethernet
%token tokenRing token-ring
%token fixedAddress fixed-address
%token ddnsHostname ddns-hostname

// Strings
%token  quote_         "        -> string
%token  string:string  [^"]+
%token  string:_quote  "        -> default

// Objects
%token brace_ {
%token _brace }

// Rest
%token comma ,
%token semicolon ;
%token ip (\d{1,3}\.){3}\d{1,3}
%token hardwareAddress [0-9a-fA-F]{1,2}(:[0-9a-fA-F]{1,2})*
%token domainName [a-zA-Z0-9]([a-zA-Z0-9-_]*[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-_]*[a-zA-Z0-9])?)*

#config:
    host()*

string:
    ::quote_:: <string> ::_quote::

ip:
    <ip>

#host:
    ::host:: hostName() ::brace_:: hostBody() ::_brace::

hostBody:
    hostParameter()*

#hostName:
    <domainName>

hostParameter:
    hardware() | fixedAddress() | ddnsHostname()

#hardware:
    ::hardware:: hardwareType() hardwareAddress() ::semicolon::

#hardwareType:
    <ethernet> | <tokenRing>

#hardwareAddress:
    <hardwareAddress>

#fixedAddress:
    ::fixedAddress:: address() ( ::comma:: address() )* ::semicolon::

address:
    ip() | domainName()

domainName:
    <domainName>

#ddnsHostname:
    ::ddnsHostname:: string() ::semicolon::
