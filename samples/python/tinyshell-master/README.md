# Overview

Dead simple remote shell, including some helpers:

- `shell.py`: a simple terminal for executing commands on the remote host
- `tramp.py`: uses a FISH-like system for uploading files.

# To Do:

- make `tramp.py` tolerant of the remote host not having `base64` (for non-Linux hosts).
- make both support `POST` instead of `GET`.
