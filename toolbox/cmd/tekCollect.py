#!/usr/bin/env python3

"""
This is tekCollect! This tool will scrape specified data types out of a URL or file.
@TekDefense
Ian Ahl | www.TekDefense.com | 1aN0rmus@tekDefense.com
Version: 0.6

Changelog:
.6
[+] Updated to Python 3 and switched from httplib2 to requests for HTTP requests.
[+] Cleaned up the regex patterns and Python code for better readability and performance.
"""

import re
import sys
import argparse
import requests

def banner():
    print("\nThis is tekCollect! A tool to scrape specified data types from a URL or file.\n")

def setup_parser():
    dTypes = 'MD5, SHA1, SHA256, MySQL, WP (WordPress), Domain, URL, IP4, IP6, SSN, EMAIL, CCN, Twitter, DOC, EXE, ZIP, IMG, FLASH'
    parser = argparse.ArgumentParser(description='tekCollect is a tool that will scrape a file or website for specified data')
    parser.add_argument('-u', '--url', help='URL to search for data')
    parser.add_argument('-f', '--file', help='File to import that contains data')
    parser.add_argument('-o', '--output', help='Output results to a file.')
    parser.add_argument('-r', '--regex', help='Custom regex pattern to use for searching.')
    parser.add_argument('-t', '--type', help='Type of data to search for. Supports: ' + dTypes)
    parser.add_argument('-s', '--summary', action='store_true', help='Show a summary of data types in the target')
    return parser.parse_args()

def search_content(content, pattern):
    return set(re.findall(pattern, content))

def main():
    args = setup_parser()
    banner()

    if not args.url and not args.file:
        print("Error: No source specified. Use -u for URL or -f for file.")
        sys.exit(1)

    content = ''
    if args.url:
        try:
            response = requests.get(args.url)
            content = response.text
        except requests.exceptions.RequestException as e:
            print(f"Failed to retrieve URL: {str(e)}")
            sys.exit(1)
    elif args.file:
        try:
            with open(args.file, 'r') as file:
                content = file.read()
        except IOError as e:
            print(f"Failed to read file: {str(e)}")
            sys.exit(1)

    if args.summary:
        summary_info = {}
        for name, pattern in patterns.items():
            found_items = search_content(content, pattern)
            if found_items:
                summary_info[name] = len(found_items)
        for dtype, count in summary_info.items():
            print(f"{dtype}: {count} instances found")
        return

    regex = args.regex or patterns.get(args.type.upper(), '')
    if not regex:
        print(f"Invalid or missing type. Available types are: {', '.join(patterns.keys())}")
        sys.exit(1)

    found_items = search_content(content, regex)
    if args.output:
        try:
            with open(args.output, 'w') as file:
                for item in found_items:
                    file.write(f"{item}\n")
            print(f"Results have been written to {args.output}")
        except IOError as e:
            print(f"Failed to write to file: {str(e)}")
            sys.exit(1)
    else:
        for item in found_items:
            print(item)

if __name__ == '__main__':
    main()
