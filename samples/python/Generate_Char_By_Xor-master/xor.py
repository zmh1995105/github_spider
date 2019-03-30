import sys

def h(x):
    asciix = ord(x)
    xormap = r"',<.>/?`~!@#$%^&*()-_=+|{[}];:"
    result = []
    for i in xormap:
        for j in xormap:
            if (j, i) in result:
                continue
            if ord(i)^ord(j) == asciix:
                result.append((i, j))
    return result

class Printer():

    def __init__(self, char_group):
        self.char_group = char_group
        self.char_ptr = len(char_group) - 1
        self.counter_group = [0 for i in range(len(self.char_group))]
        total_num = 1
        for i in range(len(self.char_group)):
            total_num *= len(self.char_group[i])
        self.total_num = total_num

    def handler(self):
        self.counter_group[self.char_ptr] += 1
        if self.counter_group[self.char_ptr] >= len(self.char_group[self.char_ptr]):   
            self.counter_group[self.char_ptr] = 0
            self.char_ptr -= 1
            if self.char_ptr >= 0:
                self.handler()
            self.char_ptr = len(self.char_group) - 1

    def arrange(self):
        for i in range(self.total_num):
            attrlist = []
            for j in range(len(self.char_group)):
                attrlist.append(self.char_group[j][self.counter_group[j]])
            temp_1 = ""
            temp_2 = ""
            for k in attrlist:
                temp_1 += k[0]
                temp_2 += k[1]
            print(f'"{temp_1}"^"{temp_2}"')
            self.handler()

def main():
    target = sys.argv[1]
    print("\n[*]Gernerate " + target + " by: \n")
    if len(target) == 1:
        temp = h(target)
        for i in temp:
            print(f'"{i[0]}"^"{i[1]}"')
    else :
        result = []
        for i in target:
            result.append(h(i))
        print_r = Printer(result)
        print_r.arrange()

main()
