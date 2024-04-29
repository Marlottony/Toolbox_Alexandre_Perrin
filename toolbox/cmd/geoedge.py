import sys
import re
import http.client

def banner():
    print("\n")
 
def usage():
    banner()
    print("Usage:")
    print("       python geoedge.py host/ip\n")
    return

if len(sys.argv) < 2:
    usage()
    sys.exit()

host = sys.argv[1]

banner()
body = "ips=" + host

try:
    conn = http.client.HTTPConnection("www.maxmind.com")
    headers = {
        'Content-type': "application/x-www-form-urlencoded",
        'Content-length': str(len(body))
    }
    conn.request('POST', "/app/locate_ip", body, headers)
    response = conn.getresponse()
    data = response.read().decode()

    limit = re.compile("reached.*")
    if limit.findall(data) != []:
        print("Limit reached in maxmind :(\n")
    else:
        res = re.compile(r"<td><font size=\"-1\">.*</font>")
        results = res.findall(data)
        res = []
        for x in results:
            x = x.replace("<td><font size=\"-1\">", "").replace("</font>", "")
            res.append(x)

        print("Information for " + host + " by Maxmind")
        print("===========================================\n")
        print("IP/Host: " + host)
        country = re.sub("<.*nk>\">", "", res[1])
        country2 = country.replace("</a>", "")
        country = re.sub("<.*middle\" >", "", country2)
        print("Country: " + country + "," + res[2])
        print("City: " + res[4] + "," + res[5])
        print("Coordinates: " + res[7] + "," + res[8])
        print("Provider: " + res[9] + "," + res[10])
        print("Google Maps Link: " + "http://maps.google.com/maps?q=" + res[7] + ", " + res[8])
        print("Mapquest Link: " + "http://www.mapquest.es/mq/maps/latlong.do?pageId=latlong&latLongType=decimal&txtLatitude=" + res[7] + "&txtLongitude=" + res[8])
        print("\n")
except Exception as e:
    print("Connection error or data processing issue:", str(e), "\n")

try:
    conn = http.client.HTTPConnection("www.geoiptool.com")
    conn.request('GET', "/es/?IP=" + host, headers={'Host': 'www.geoiptool.com', 'User-agent': 'Internet Explorer 6.0 '})
    response = conn.getresponse()
    data = response.read().decode()

    res = re.compile(r"<td align=\"left\" class=\"arial_bold\">.*</td>")
    results = res.findall(data)
    res = []

    for x in results:
        x = x.replace("<td align=\"left\" class=\"arial_bold\">", "").replace("</td>", "")
        res.append(x)

    print("Information by Geoiptool")
    print("========================\n")
    print("IP/Host: " + res[0])
    country = re.sub("<.*nk\">", "", res[1])
    country = country.replace("</a>", "")
    country = re.sub("<.*middle\" >", "", country)
    print("Country: " + country + "," + res[2])
    city = re.sub("<.*nk\">", "", res[3])
    city = city.replace("</a>", "")
    print("City: " + city + "," + res[4])
    print("Coordinates: " + res[8] + "," + res[7])
    print("\n")
except Exception as e:
    print("Connection error or data processing issue:", str(e), "\n")


