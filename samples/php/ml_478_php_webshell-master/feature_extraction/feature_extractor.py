from neopi import Entropy
from neopi import LanguageIC
from neopi import LongestWord
from neopi import SignatureNasty
from neopi import SignatureSuperNasty
from neopi import UsesEval
from neopi import Compression
import csv
import os
import chardet
import sys

def calculate_results(path, filename, label):
    encoding = chardet.detect(open(path+filename, 'rb').read())
    with open(path+filename, 'r', encoding=encoding['encoding']) as f:
        ic = LanguageIC().calculate(f.read(), filename)
        f.seek(0)
        entropy = Entropy().calculate(f.read(), filename)
        f.seek(0)
        nasty_sig_count = SignatureNasty().calculate(f.read(), filename)
        f.seek(0)
        super_nasty_count = SignatureSuperNasty().calculate(f.read(), filename)
        f.seek(0)
        uses_eval = UsesEval().calculate(f.read(), filename)
        f.seek(0)
        longest_word_length = LongestWord().calculate(f.read(), filename)
    with open(path+filename, 'rb') as f:
        compression_ratio = Compression().calculate(f.read(), filename)
        file_size = os.path.getsize(path+filename)
        return [filename, file_size, ic, entropy, nasty_sig_count, super_nasty_count, uses_eval, compression_ratio, longest_word_length, label]



if __name__ == "__main__":

    if sys.argv[1] == '1':
        with open('../datasets/backdoor_webshells_features.csv', 'w') as csvfile:
            writer = csv.writer(csvfile)
            writer.writerow(["Filename", "File_Size", "Index_of_Coincidence", "Entropy", "Nasty_Sig_Count", "Super_Nasty_Sig_Count", "Eval_Uses", "Compression_Ratio", "Longest_Word_Length", "Label"])
            count = 0
            for f in os.listdir("../data_sources/php_webshells"):
                print("Starting Extraction on: {}: {}".format(f, count))
                try: 
                    writer.writerow(calculate_results("../data_sources/php_webshells/", f, 1)) 
                    count += 1
                except Exception as e:
                    print ("Could not extract: {}".format(f))
            for f in os.listdir("../data_sources/non_webshells"):
                print("Starting Extraction on: {}: {}".format(f, count)) 
                try:
                    writer.writerow(calculate_results("../data_sources/non_webshells/", f, 0)) 
                    count += 1
                except Exception as e:
                    print ("Could not extract: {}".format(f))

    else:
        print(calculate_results("./", "shell.php",1 ))

