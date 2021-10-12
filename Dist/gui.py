
# This file was generated by the Tkinter Designer by Parth Jadhav
# https://github.com/ParthJadhav/Tkinter-Designer

import webbrowser
import mysql.connector
from dotenv import load_dotenv
import os

from pathlib import Path

# from tkinter import *
# Explicit imports to satisfy Flake8
from tkinter import Tk, Canvas, Entry, Text, Button, PhotoImage, messagebox


# db stuff
db = mysql.connector.connect(
    host= "na05-sql.pebblehost.com",
    user= "customer_179919_collatzdb",
    password= "s6jYWqX1$iu0HiHgXMDd",
    database= "customer_179919_collatzdb",
)
cursor = db.cursor(buffered=True)

window = Tk()
window.title("Collatz Collab Setup")

window.geometry("569x640")
window.configure(bg = "#2D283E")


canvas = Canvas(
    window,
    bg = "#2D283E",
    height = 640,
    width = 569,
    bd = 0,
    highlightthickness = 0,
    relief = "ridge"
)

canvas.place(x = 0, y = 0)
canvas.create_rectangle(
    0.0,
    0.0,
    569.0,
    640.0,
    fill="#2D283E",
    outline="")

canvas.create_text(
    189.0,
    41.0,
    anchor="nw",
    text="Welcome to",
    fill="#D1D7E0",
    font=("Roboto Bold", 36 * -1)
)

canvas.create_text(
    85.0,
    96.0,
    anchor="nw",
    text="Collatz Collab",
    fill="#802BB1",
    font=("Roboto Bold", 64 * -1)
)

entry_1 = Entry(
    bd=2,
    bg="#2D283E",
    highlightthickness=0,
    font=("Roboto Bold", 44 * -1),
    fg="#D1D7E0",

)
entry_1.place(
    x=103.0,
    y=242.0,
    width=364.0,
    height=55.0
)

canvas.create_text(
    94.0,
    211.0,
    anchor="nw",
    text="Email",
    fill="#FFFFFF",
    font=("Roboto Bold", 24 * -1)
)

import os


def button_1_clicked():
    emailEntered = entry_1.get()
    cursor.execute(f"SELECT id FROM users WHERE email = '{emailEntered}'")
    testerID1 = cursor.fetchone()
    global testerID
    for testerID in testerID1:
        pass
    
    

    msg = messagebox.showinfo("Success!", "Login successful. Thank you for using Collatz Collab. The program has started, for more info on the program and how to stop it, visit https://collatzcollab.com/download.\nYou can now close this app.")
    if msg == "ok":
        window.destroy()



button_1 = Button(
    borderwidth=0,
    highlightthickness=0,
    command=button_1_clicked,
    relief="flat",
    text="Sign In",
    bg="#2D283E",
    fg="#802BB1",
    font=("Roboto Bold", 24 * -1)
)
button_1.place(
    x=178.0,
    y=427.0,
    width=212.0,
    height=78.0
)

canvas.create_text(
    178.0,
    541.0,
    anchor="nw",
    text="Don't have an account?",
    fill="#D1D7E0",
    font=("Roboto Bold", 18 * -1)
)

def button_2_clicked():
    signUpLink = (
        "https://collatzcollab.com/signup"
    )
    webbrowser.open_new_tab(signUpLink)

button_2 = Button(
    borderwidth=0,
    highlightthickness=0,
    command=button_2_clicked,
    relief="flat",
    text="Sign Up",
    bg="#2D283E",
    fg="#802BB1",
    font=("Roboto Bold", 20 * -1)
)
button_2.bind('<Button-2>', button_2_clicked)
button_2.place(
    x=222.0,
    y=558.0,
    width=122.0,
    height=51.0
)

window.resizable(False, False)
window.mainloop()
