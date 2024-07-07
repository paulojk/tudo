import os,sys,time

os.system("clear")

def line():
	print("~"*50)
	
def tmr(seconds):
	while seconds:
		mins, secs = divmod(seconds, 60)
		hour, mins = divmod(mins, 60)
		timer = " {:02d}:{:02d}:{:02d} ".format(hour, mins, secs)
		print(timer,end="\r")
		time.sleep(1)
		seconds -= 1
try:
	import telethon
except ImportError:
	print("# installing modul telethon")
	os.system("pip install telethon")

from telethon import TelegramClient,sync
from telethon import functions, types
from telethon.tl.functions.channels import JoinChannelRequest

try:
	import requests
except ImportError:
	print("# installing modul requests")
	os.system("pip install requests")
	import requests

if not os.path.exists('session'):
	os.makedirs('session')

api_id = '1988466'
api_hash = 'c24b35d219f6856b93c90ab02b52b147'

if len(sys.argv) < 2:
	exit("Usage: python "+sys.argv[0]+" +6285xxxxxxx")

phone_number = sys.argv[1]
client = TelegramClient('session/'+phone_number,api_id,api_hash)
client.start(phone_number)
me = client.get_me()

try:
	print("Welcome : "+me.username)
except:
	print("Welcome : "+me.first_name)
line()

channel_entity = client.get_entity("@TONClaimerBot")
client.send_message(entity=channel_entity,message="/start 6192660395")
time.sleep(5)
r = client.get_messages(channel_entity,limit=2)
if "you must join" in r[1].message:
	print(r[1].message)
	chnel = "@AdBeastBots"
	client(JoinChannelRequest(f"{chnel}"))
	time.sleep(1)
	r[1].click(text="✅Joined")
	time.sleep(7)
	r = client.get_messages(channel_entity,limit=2)
	if "please verify your identity" in r[0].message:
		exit(r[0].message)
elif "please verify your identity" in r[0].message:
	exit(r[0].message)
else:
	print("Bot running...")
	line()

while(1):
	client.send_message(entity=channel_entity,message="🎉🎁 Mystery Box 🎁🎉")
	time.sleep(5)
	r = client.get_messages(channel_entity,limit=1)
	r[0].click(text="⏳ Open Mystery Box")
	time.sleep(5)
	r = client.get_messages(channel_entity,limit=1)
	try:
		url = r[0].reply_markup.rows[0].buttons[0].url
	except:
		continue
		
	requests.get(url=url)
	time.sleep(10)
	final = url.replace("mystery","claim")
	r = requests.get(url=final)
	if "Captcha Verified" in r.text:
		print("Captcha Verified")
		time.sleep(7)
		r = client.get_messages(channel_entity,limit=2)
		print(r[0].message.splitlines()[0])
		client.send_message(entity=channel_entity,message="💰 Balance")
		time.sleep(5)
		r = client.get_messages(channel_entity,limit=2)
		balan = r[0].message.splitlines()[3].strip()
		print("balance: "+balan)
		line()
		tmr(60)
	else:
		exit("Web e update paleng")
		