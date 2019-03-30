#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <openssl/des.h>
 
#define BUFSIZE 1024 

int main(int argc, char* argv[])
{
        unsigned char in[BUFSIZE], out[BUFSIZE], back[BUFSIZE], keyn[BUFSIZE];
        char buf[201];

        unsigned char *e = out;
	int i, num, len, result;
        int n = 0;
	FILE* fin;

	int eflag=0;
	int dflag=0;
	int c;
	char* infile; 
	char* outfile;
	char* keyfile;

        DES_cblock key;
        DES_cblock ivsetup = {0xE1, 0xE2, 0xE3, 0xD4, 0xD5, 0xC6, 0xC7, 0xA8};
        DES_key_schedule ks;
        DES_cblock ivec;

        memset(in, 0, sizeof(in));
        memset(out, 0, sizeof(out));
        memset(back, 0, sizeof(back));
 


 

 
	while((c=getopt(argc, argv,"edi:o:k:"))!=-1)
	{
		switch(c)
		{

			case 'i': 
				infile=optarg;
				break;

			case 'o': 
				outfile=optarg;
				break;

			case 'k':
				keyfile=optarg;
				break;


			case 'e':
				eflag=1;
				break;

			case 'd': 
				dflag=1;
				break;



			case '?':
					if(optopt=='i' || optopt== 'o' || optopt== 'k')
					{
						fprintf(stderr,"Option -%c needs argument",optopt);
						
					}
					else
					{
						fprintf(stderr,"ERROR!!");
						return 1;
					}					


					break;

			default: printf("Error!!\n");
					 return 1;


		} 
	}


       		
	FILE *fkey;
       fkey = fopen(keyfile, "r");
       if (!fkey) {
       	   printf("ERROR: opening input file\n");
          exit(1);
       	}
       while(fgets(buf, 200, fkey) != NULL) {
           strcat(keyn, buf);
       	}
       fclose(fkey);

	char *keystr = keyn;	
	DES_string_to_key(keystr, &key);
 	printf("Keytext: [%s]\n", keystr);
		
	if ((result = DES_set_key_checked((C_Block *)key, &ks)) != 0) {
	   if (result == -1) {
          printf("ERROR: key parity is incorrect\n");
	    } else {
          printf("ERROR: weak or semi-weak key\n");
           }
            exit(1);
	}




	if((eflag==1 && dflag==0) || (eflag==0 && dflag==1))
	{



       		fin = fopen(infile, "r");
     		  if (!fin) {
       		    printf(" ERROR: opening input file\n");
        	   exit(1);
       		}
    	       while(fgets(buf, 200, fin) != NULL) {
           		strcat(in, buf);
       		}
       	       fclose(fin);
 
 
     	  	printf("Input Text: [%s]\n", in);
        	  len = strlen(in);
       		printf("Input Text Length: %d\n", len);

		memcpy(ivec, ivsetup, sizeof(ivsetup));
       		num = 0;
       		for (i = 0; i < len; i++) {
           	DES_ede3_ofb64_encrypt(&(in[i]), &(out[i]), 1, &ks, &ks, &ks, &ivec, &num);
       		}

		char * outtemp;

		n = 0;
       		printf("Ciphertext:");
       		while (*e) {
           		printf(" [%02x]", *e++);
           		n++;
       		}
       		printf("\n");
   //    		printf("Ciphertext Length: %d\n", n);

		
		printf("Output File Text:[%s]",out);

	       FILE *fout = fopen(outfile, "ab");
  		  if (fout != NULL)
         	{
       		 fputs(out, fout);
        	fclose(fout);
    		}
 

	}



	return 0;

}
