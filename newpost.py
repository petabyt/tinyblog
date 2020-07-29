import os
import sys
import subprocess

files = len(os.listdir("posts"));
subprocess.run(["mkdir", str(files + 1)])
subprocess.run(["tilde", "posts/" + str(files + 1)])
