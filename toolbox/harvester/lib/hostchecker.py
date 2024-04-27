#!/usr/bin/env python
# encoding: utf-8
"""
Created by laramies on 2008-08-21.
"""

import sys
import socket

class Checker():
	def __init__(self, hosts):
		self.hosts = hosts
		self.realhosts=[]

import socket  # Ensure the socket module is imported

def check(self):
    for x in self.hosts:
        try:
            res = socket.gethostbyname(x)
            self.realhosts.append(res + ":" + x)
        except Exception as e:  # Updated to Python 3 exception syntax
            pass
    return self.realhosts
		
