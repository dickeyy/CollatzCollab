
# This file was generated by the Tkinter Designer by Parth Jadhav
# https://github.com/ParthJadhav/Tkinter-Designer

import webbrowser
import mysql.connector
from dotenv import load_dotenv
import os

from pathlib import Path

# from tkinter import *
# Explicit imports to satisfy Flake8
from tkinter import Tk, Canvas, Entry, Text, Button, PhotoImage


# db stuff
load_dotenv()
db = mysql.connector.connect(
    host= os.getenv("HOST"),
    user= os.getenv("USER"),
    password= os.getenv("PASSWORD"),
    database= os.getenv("DATABASE"),
)
cursor = db.cursor(buffered=True)
print("Connected to DB")

OUTPUT_PATH = Path(__file__).parent
ASSETS_PATH = OUTPUT_PATH / Path("./assets")


def relative_to_assets(path: str) -> Path:
    return ASSETS_PATH / Path(path)


window = Tk()
logo = PhotoImage(file=ASSETS_PATH / "collatzLogo.png")
window.call('wm', 'iconphoto', window._w, logo)
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

entry_image_1 = PhotoImage(
    file=relative_to_assets("entry_1.png"))
entry_bg_1 = canvas.create_image(
    285.0,
    270.5,
    image=entry_image_1
)
entry_1 = Entry(
    bd=0,
    bg="#2D283E",
    highlightthickness=0,
    font=("Roboto Bold", 48 * -1),
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

def button_1_clicked():
    emailEntered = entry_1.get()
    cursor.execute(f"SELECT id FROM users WHERE email = '{emailEntered}'")
    testerID1 = cursor.fetchone()
    for testerID in testerID1:
        pass
    file1 = open("testerID.txt","a")
    file1.write(testerID)
    file1.close()


button_image_1 = PhotoImage(
    file=relative_to_assets("button_1.png"))
button_1 = Button(
    image=button_image_1,
    borderwidth=0,
    highlightthickness=0,
    command=button_1_clicked,
    relief="flat"
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

button_image_2 = PhotoImage(
    file=relative_to_assets("button_2.png"))
button_2 = Button(
    image=button_image_2,
    borderwidth=0,
    highlightthickness=0,
    command=button_2_clicked,
    relief="flat"
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