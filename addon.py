# https://www.janssuuh.nl/en/skin-audi-rns-full-beta/
# I guess this wonderful gentleman is responsible for finding the CAN codes
# that represent key presses

#!/root/.xbmc/userdata/Rnse_Bediening.py

# HIERONDER IMPORTS EN VARIABELEN DECLAREREN
# __________________________________________

from __future__ import print_function
import xbmc
import xbmcgui
import os
import sys
import threading
import can
can.rc['interface'] = 'socketcan_ctypes'
from threading import Thread, Timer
from can.interfaces.interface import Bus
can_interface = 'can0'

global var
var=1			# Bij afsluiten wordt var0


# HIERONDER FUNCTIES PLAATSEN / DECLAREREN
# __________________________________________

def dumpcan(): # Can berichten scannen + omzetten naar kodi / python acties
	global var
	up=0
	down=0
	prev=0
	next=0
	press=0
	retrn=0
	setup=0
	windowid=0

	for message in Bus(can_interface):
		if var==1:
			msg = unicode(message).encode('utf-8')
			canid = msg[26:29]
			msg = msg[45:69]

			if canid == ("461"): # Canid 461 wordt gebruikt voor het gebruik van RNS-E knoppen.
				if msg == ("37 30 01 40 00 00"): #Up
					if up==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Up","id":1}')
						up=0
					else:
						up+=1
				elif msg == ("37 30 01 80 00 00"): #Down
					if down==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Down","id":1}')
						down=0
					else:
						down+=1
				elif msg == ("37 30 01 00 40 01"): #Left
					windowid = xbmcgui.getCurrentWindowId()
					if (windowid == 12006): # MusicVisualisation.xml of VideoFullScreen.xml
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":0,"value":"smallbackward"},"id":1}')
					elif (windowid == 12005):
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":1,"value":"smallbackward"},"id":1}')
					else:
							xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Left","id":1}')
				elif msg == ("37 30 01 00 20 01"): #Right
					windowid = xbmcgui.getCurrentWindowId()
					if (windowid == 12006): # MusicVisualisation.xml of VideoFullScreen.xml
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":0,"value":"smallforward"},"id":1}')
					elif (windowid == 12005):
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":1,"value":"smallforward"},"id":1}')
					else:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Right","id":1}')
				elif msg == ("37 30 01 01 00 00"): #Previous
					if prev==1:
						xbmc.executebuiltin('XBMC.PlayerControl(Previous)')
						prev=0
					else:
						prev+=1
				elif msg == ("37 30 01 02 00 00"): #Next
					if next==1:
						xbmc.executebuiltin('XBMC.PlayerControl(Next)')
						next=0
					else:
						next+=1
				elif msg == ("37 30 01 00 10 00"): #Press
					if press==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Select","id":1}')
						press=0
					else:
						press+=1
				elif msg == ("37 30 01 00 02 00"): #Return
					if retrn==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Back","id":1}')
						retrn=0
					else:
						retrn+=1
				elif msg == ("37 30 01 00 01 00"): #Setup
					if setup==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":0},"id":1}')
						xbmc.executebuiltin("Notification('Speler gepauzeerd')")
						setup=0
					else:
						setup+=1

				elif msg == ("37 30 01 00 02 00"): #Return
					if retrn==1:
						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Back","id":1}')
						retrn=0
					else:
						retrn+=1
			elif (canid == "271" ) and (msg == "11"):
				os.system("sudo halt")

# HIERONDER AANROEPEN (GELIJKTIJDIG UIT TE VOEREN) FUNCTIES
# __________________________________________

dumpcan()
