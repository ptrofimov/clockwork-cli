Clockwork-cli
=============

**[Clockwork](http://github.com/itsgoingd/clockwork-chrome) is a Chrome extension for PHP development**, extending Developer Tools with a new panel providing all kinds of information useful for debugging and profiling your PHP applications, including information about request, headers, get and post data, cookies, session data, database queries, routes, visualisation of application runtime and more.

This is command line interface for Clockwork.

## Installation

* Install clockwork-cli via composer for your project:
```
composer require ptrofimov/clockwork-cli:*
```
* Or install clockwork-cli globally:
```
composer global require ptrofimov/clockwork-cli:*
```

## Usage

* Run script to monitor clockwork logs for current project:
```
./bin/clockwork-cli
```
* Or you can monitor logs for many projects:
```
./bin/clockwork-cli /www/*
```
* You will see updating list of HTTP requests. The first character is a hotkey.
* Press the hotkey to view details of HTTP request.
* Press Backspace to show requests for last 10 minutes
* Press Escape to exit

## Licence

Copyright (c) 2014 Petr Trofimov

MIT License

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
