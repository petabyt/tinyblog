import os
import sys
import subprocess

files = len(os.listdir("posts"));
subprocess.run(["tilde", "posts/" + str(files)])
