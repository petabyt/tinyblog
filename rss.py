# Basic Python3 RSS generator.
# python3 rss.py > rss.xml

import os, re

url = "https://petabyt.dev/blog/"
title = "XXX"

print("""
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
      <title>XXX</title>
        <link>XXX</link>
        <description>XXX</description>
        <generator>Tinyblog</generator>
        <language>en</language>
        <lastBuildDate>Mon, 08 Feb 2021 00:00:00 +0000</lastBuildDate>
""")

def getMatch(a):
    return a.groups(0)[0]


files = os.listdir("posts/")

for i in range(1, len(files)):
    fp = open("posts/" + str(i))
    text = fp.read()
    text = re.sub(r"# (.+)", getMatch, text)
    text = text.split("\n")
    print("""
        <item>
        <title>""" + text[0] + """</title>
        <pubDate>""" + text[1] + """</pubDate>
        <link>""" + url + str(i) + """</link>
        <guid>""" + url + str(i) + """</guid>
        <description>""" + text[2] + """</description>
        </item>""")

print("""
    </channel>
</rss>
""")
