%skip space \s

// Scalars
%token comment #[^\n]*\n

%token lease lease
%token starts starts
%token ends ends
%token tstp tstp
%token tsfp tsfp
%token atsfp atsfp
%token cltt cltt
%token hardware hardware
%token ethernet ethernet
%token tokenRing token-ring
%token clientHostname client-hostname
%token abandoned abandoned
%token bindingState binding state
%token active active
%token free free
%token backup backup
%token next next
%token rewind rewind
%token option option
%token set set
%token equals =
%token bootp bootp
%token reserved reserved
%token ddnsTxt ddns-txt
%token ddnsFwdName ddns-fwd-name
%token ddnsClientFqdn ddns-client-fqdn
%token ddnsRevName ddns-rev-name
%token failOverPeer failover peer
%token state state
%token myState my state
%token partnerState partner state
%token at at
%token uid uid
%token serverDuid server-duid

%token unknownState unknown-state
%token partnerDown partner-down
%token normal normal
%token communicationsInterrupted communications-interrupted
%token resolutionInterrupted resolution-interrupted
%token potentialConflict potential-conflict
%token recover recover
%token recoverDone recover-done
%token shutdown shutdown
%token paused paused
%token startup startup

%token agentCircuitId agent\.circuit-id
%token agentRemoteId agent\.remote-id

%token epoch epoch
%token never never

%token ip \d{1,3}(\.\d{1,3}){3}
%token defaultDate \d \d+/\d+/\d+ \d+:\d+:\d+
%token hardwareAddress [0-9a-fA-F]{1,2}(:[0-9a-fA-F]{1,2})+
%token quotedString "[^"]*"
%token timestamp \d+

%token brace_ {
%token _brace }

%token semicolon ;

#leaseFile:
    ( comment() | lease() | failOverPeer() | serverDuid() )*

comment:
    ::comment::

#lease:
    ::lease:: ip() ::brace_:: leaseBody() ::_brace::

#ip:
    <ip>

date:
    defaultDate() | localDate() | dateNever()

defaultDate:
    <defaultDate>

localDate:
    ::epoch:: <timestamp>

dateNever:
    <never>

leaseBody:
    ( leaseDate() | clientData() | leaseState() | leaseConfiguration() )*

leaseDate:
    starts() | ends() | tstp() | tsfp() | atsfp() | cltt()

clientData:
    hardware() | uid() | clientHostname()

leaseState:
    abandoned() | bootp() | reserved() | bindingState() | nextBindingState() | rewindBindingState()

leaseConfiguration:
    option() | set()

#starts:
    ::starts:: date() ::semicolon::

#ends:
    ::ends:: date() ::semicolon::

#tstp:
    ::tstp:: date() ::semicolon::

#tsfp:
    ::tsfp:: date() ::semicolon::

#atsfp:
    ::atsfp:: date() ::semicolon::

#cltt:
    ::cltt:: date() ::semicolon::

#hardware:
    ::hardware:: hardwareType() macAddress() ::semicolon::

#hardwareType:
    <ethernet> | <tokenRing>

#macAddress:
    <hardwareAddress>

#uid:
    ::uid:: clientIdentifier() ::semicolon::

clientIdentifier:
    <hardwareAddress> | <quotedString>

#clientHostname:
    ::clientHostname:: <quotedString> ::semicolon::

#abandoned:
    ::abandoned:: ::semicolon::

#bootp:
    ::bootp:: ::semicolon::

#reserved:
    ::reserved:: ::semicolon::

#bindingState:
    ::bindingState:: stateValue() ::semicolon::

#nextBindingState:
    ::next:: ::bindingState:: stateValue() ::semicolon::

#rewindBindingState:
    ::rewind:: ::bindingState:: stateValue() ::semicolon::

stateValue:
    <active> | <free> | <backup>

#option:
    ::option:: optionName() optionValue() ::semicolon::

optionName:
    <agentCircuitId> | <agentRemoteId>

optionValue:
    <quotedString>

#set:
    ::set:: variableName() ::equals:: variableValue() ::semicolon::

#variableName:
    <ddnsTxt> | <ddnsFwdName> | <ddnsClientFqdn> | <ddnsRevName>

#variableValue:
    <quotedString>

#failOverPeer:
    ::failOverPeer:: peerName() ::state:: ::brace_:: failOverPeerBody() ::_brace::

#peerName:
    <quotedString>

failOverPeerBody:
    ( failOverMyState() | failOverPeerState() )*

#failOverMyState:
    ::myState:: failOverState() ::at:: date() ::semicolon::

#failOverPeerState:
    ::partnerState:: failOverState() ::at:: date() ::semicolon::

#failOverState:
    <unknownState> | <partnerDown> | <normal> | <communicationsInterrupted> | <resolutionInterrupted> | <potentialConflict> | <recover> | <recoverDone> | <shutdown> | <paused> | <startup>

#serverDuid:
    ::serverDuid:: <quotedString> ::semicolon::
