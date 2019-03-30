# _*_ coding: utf-8 _*_
#
# @author: Alvin
# @create time: 2018.2.7

# Python Lib
import sys
import getopt


def main(argv):

    system = ''
    root = ''

    try:
        opts, args = getopt.getopt(argv, "hs:r:", ["system=", "root="])
    except getopt.GetoptError as error:
        print(error)
        print('****** The correct format is: ******')
        print('test.py -s <system> -r <root>')
        sys.exit(2)

    for opt, arg in opts:
        if opt == '-h':
            print('****** Help Information ******')
            print('test.py -s <system> -r <root>')
            sys.exit()
        elif opt in ("-s", "--system"):
            system = arg
        elif opt in ("-r", "--root"):
            root = arg

    print('system type: ', system)
    print('root dir: ', root)

if __name__ == "__main__":
    main(sys.argv[1:])
