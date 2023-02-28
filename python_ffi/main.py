import c_lib

if __name__ == '__main__':
    print(f"""
| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): {c_lib.getRandom(0, 9)}
| generateUUID():  {c_lib.generateUUID()}
| -----------------------------------------------------
    """)
