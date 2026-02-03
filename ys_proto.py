#!/usr/bin/python3
# -*- coding: utf-8 -*-


# Author:      Vincent A
# Description: Library to talk to an YSFlight server
# Usage:       Modify the classes Server and Apps to your needs

# No more than 80 characters by line

from struct import pack, unpack
import sys, socket, json, logging

# TODO: logger, to  avoid all the 'print'
# TODO: test when the server doesn't reply, the script must stop

class YS_proto_snd:
    """Serialization class: each method return the serialized data
    (the packet) to send data to the YSFlight server"""
    def snd(self, buffer):
        """Add to a packet the 'size' information"""
        return pack("I", len(buffer))+buffer

    def reply(self, type, buffer):
        """
        Shortcut to reply the packet you received
        @type int: the type of the received packet
        @type char[]: the received buffer
        @return: the reply
        """
        return self.snd(pack("I", type)+buffer)

    def ack(self, id, info):
        """
        Shortcut to send an acknowledgement packet
        """
        return pack('IIII',12,6,id,info)


    def login(self, username="test_user", version=20110207):
        """
        Returns a packet of type 1: login
        @type str: username
        @type int: YS net-version
        @return: The login packet
        """
        username = username[0:15].encode('utf-8')
        version = int(version)
        return self.snd(pack("I16sI",1,username, version))

    def oneint(self, integer):
        return self.snd(pack("I", int(integer)))

class YS_proto_rcv:
    """Serialization class: each method return the information
    extracted from the serialized data in 'buffer'"""
    def airDisplayOpt(self, buffer):
        """
        Read packet of type 43
        @type byte[]: buffer
        @return: The tuple (unknown, option)
        """
        decode = "I"+str(len(buffer)-4)+"s"
        return unpack(decode,buffer)

    def map(self, buffer):
        """
        Read packet of type 4
        @type bytes: buffer
        @return: A tuple containing the name of the map
        """
        return unpack("60s",buffer)


    def msg(self, buffer):
        """
        Read packet of type 32
        @type bytes: buffer
        @return: The tuple (unknown_long, chat_message)
        """
        decode = "l"+str(len(buffer)-8)+"s"
        return unpack(decode,buffer)

    def oneint(self, buffer):
        """
        Read packet of type 29, 31, 39
        @type bytes: buffer
        @return: (tuple) The YS version of the server,
                 if the missiles are on or off,
                 if the weapons are on or off, ...
        """
        return unpack("I",buffer)


    def userList(self, buffer):
        """
        Read packet of type 37
        @type bytes: buffer
        @return: The tuple (action, IFF, ID, unknown, nickname)
        """
        decode = "hhII"+str(len(buffer)-12)+"s"
        return unpack(decode,buffer)

    def weather(self, buffer):
        """
        Read packet of type 33
        @type bytes: buffer
        @return: The tuple (day, options, windX, windY, windZ, visib)
        """
        return unpack("IIffff",buffer)


class Server:
    """Class to store all the information we got from our communication
    with the YSFlight server."""
    def __init__(self, ip, port):
        self.ip         = ip
        self.port       = port
        self.version    = 20110207
        self.status     = "offline"
        self.map        = ""
        self.missileON  = 0
        self.weaponON   = 0
        self.blackoutON = 0
        self.collON     = 0
        self.landevON   = 0
        self.weather    = (0,0,0.0,0.0,0.0,0.0)
        self.userOption = 0 # Show User Name within 'userOption' m
        self.radarAlti  = ""
        self.f3view     = True
        self.userList   = []
        self.users      = 0
        self.flyingUsers= 0

class Apps:
    """Class doing the job of communicating with the server,
    using the two serialization classes: YS_proto_snd and YS_proto_rcv
    """
    def __init__(self,ip, port, timeout):
        self.ip       = ip
        self.port     = port
        self.server   = Server(ip, port)
        self.ysrcv    = YS_proto_rcv()
        self.yssnd    = YS_proto_snd()
        self.packets  = 0
        self.version  = 0
        self.timeout  = timeout
        self.username = ''

    def connect(self,  username, version):
        """
        Start the connection and the main loop of discussion
        with the server.
        @type string: username is the nickname used for the login
        @type string: version is the net-version used for the login
        @return string: the state of the server ('online', ...)
        """
        self.s        = socket.socket()
        self.s.settimeout(self.timeout)
        self.version  = version
        self.username = username
        self.connected = False
        try:
            self.s.connect((self.ip,self.port))
            self.connected = True
        except Exception:
            self.server.status = "offline"
            return
        if not(self.send(self.yssnd.login(username, version))):
            self.server.status = "locked"
            return
        logger.info("connected")
        while self.connected and self.packets < 15: # we exit after 15 packets
            (size, type,buffer) = self.receive()
            self.packets += 1
            self.server.status = "online"
            if not(self.process(size, type, buffer)):
                self.server.status = "online" # should be laggy
            # if there were and error
            #  or if we see an aircraft_list packet, we exit
            #if type == 0:# or type==44:
                logger.info("enough!")
                self.disconnect()

    def disconnect(self):
        self.connected = False
        try:
            self.s.close()
        except Exception:
            logger.info("failed to disconnect")

    def send(self, buffer):
        """Send 'buffer' to the server
        @return: 1 if success, 0 else
        """
        try:
            self.s.send(buffer)
            return 1
        except Exception as e:
            logger.info("Send failure")
            return 0

    def receive(self):
        """Receive data from the server
        @return: the tuple (size, type, buffer)
        size=0 and type=0 in case of failure
        """
        try:
            size = self.ysrcv.oneint(self.s.recv(4))[0]
            type = self.ysrcv.oneint(self.s.recv(4))[0]
            logger.debug("size " + str(size) + " type " + str(type))
        except Exception:
            logger.debug("Receive failure 1")
            return (0, 0,"")
        try:
            return (size, type, self.s.recv(size-4))
        except Exception:
            logger.debug("Receive failure 2")
            return (size, 0,"")


    def process(self, size, type, buffer):
        """
        Takes the decision of what doing when we receive a packet
        of type X
        """
        if type == 0:
            return 0
        elif type == 4:
            self.server.map = self.ysrcv.map(buffer)[0]
            end = self.server.map.find(b'\x00')
            self.server.map = self.server.map[:end].decode('utf-8', errors='ignore')
            logger.info("map " + self.server.map)
            self.send(self.yssnd.reply(4,buffer))
            # ask to get the weather packet:
            self.send(self.yssnd.oneint(33))
            # ask to get the user-list:
            self.send(self.yssnd.oneint(37))
        elif type == 16:
            # we finished with the air-list
            self.send(self.yssnd.ack(7,0))
        elif type == 29:
            self.server.version = self.ysrcv.oneint(buffer)[0]
            logger.info("version " + str(self.server.version))
            if self.version != self.server.version:
                logger.warning("reconnecting with another net-version")
                self.disconnect()
                self.connect(self.username, self.server.version)
            else:
                self.send(self.yssnd.ack(9,0))
        elif type == 31:
            self.server.missileON = bool(self.ysrcv.oneint(buffer)[0])
            logger.info("missileON " + str(self.server.missileON))
            self.send(self.yssnd.ack(10,0))
        elif type == 32:
            msg = self.ysrcv.msg(buffer)[1].decode('utf-8', errors='ignore')
            logger.info("message " + msg)
            # A message from a server maybe player generated and does not
            # contribute to any in-game infomation, avoid incrementing
            # the packet count, as this is not progress.
            self.packets -= 1
        elif type == 33:
            self.server.weather = self.ysrcv.weather(buffer)
            opts = bin(self.server.weather[1])
            opts_str = str(opts)
            if len(opts_str) > 5:
                self.server.collON = bool(int(opts_str[-5]))
            else:
                self.server.collON = False
            if len(opts_str) > 7:
                self.server.blackoutON = bool(int(opts_str[-7]))
            else:
                self.server.blackoutON = False
            if len(opts_str) > 3:
                self.server.landevON = bool(int(opts_str[-3]))
            else:
                self.server.landevON = False
            logger.info("collON " + str(self.server.collON))
            logger.info("blackoutON " + str(self.server.blackoutON))
            logger.info("landevON " + str(self.server.landevON))
            logger.info(
                "day " + str(self.server.weather[0]) +
                " windX " + str(self.server.weather[2]) +
                " windZ " + str(self.server.weather[3]) +
                " windY " + str(self.server.weather[4]) +
                " visib " + str(self.server.weather[5])
            )
            self.send(self.yssnd.ack(4,0))
        elif type == 37: # Never received, FIXME
            user = list(self.ysrcv.userList(buffer))
            user[4] = user[4].rstrip(b'\0').decode('utf-8', errors='ignore') # to remove null at end
            user = tuple(user)
            self.server.userList.append(user)
            if user[0] == 1 or user[0] == 3:
                self.server.flyingUsers += 1
            if user[4] != self.username and user[4] != 'Console Server':
                self.server.users += 1
            logger.info("user " + str(user))
        elif type == 39:
            self.server.weaponON = bool(self.ysrcv.oneint(buffer)[0])
            logger.info("weaponON " + str(self.server.weaponON))
            self.send(self.yssnd.ack(11,0))
        elif type == 41:
            self.server.userOption = self.ysrcv.oneint(buffer)[0]
            logger.info("User option " + str(self.server.userOption))
        elif type == 43:
            self.send(self.yssnd.reply(43,buffer))
            mesg = self.ysrcv.airDisplayOpt(buffer)[1]
            if mesg[:14] == b"NOEXAIRVW TRUE":
                logger.info("no F3 view")
                self.server.f3view = False
            else:
                try:
                    self.server.radarAlti = float(mesg[10:-2])
                except Exception:
                    self.server.radarAlti = 0
                logger.info("radar alti " + str(self.server.radarAlti))
        elif type == 44:
            self.send(self.yssnd.reply(44,buffer))
            # aircraft list
        return 1

if __name__ =='__main__':
    logger = logging.getLogger('ys_proto')
    # hdlr = logging.FileHandler('/tmp/ysproto.log')
    hdlr = logging.StreamHandler(sys.stderr)
    formatter = logging.Formatter('%(asctime)s %(levelname)s %(message)s')
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    logger.setLevel(logging.INFO)

    apps = Apps(sys.argv[1], int(sys.argv[2]), 5)
    state = apps.connect("serverlist_bot", 20150425)
    print(json.dumps(vars(apps.server)))
    #print "------------cvw-------"
    #apps = Apps("cvw171.dyndns.org", 7915, 5)
    #state = apps.connect("ys_py_lib", 20110207)
    #print "state=", state
