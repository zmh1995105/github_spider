#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <pwd.h>
#include <unistd.h>

int main(int argc, char** argv) {
	if(argc != 3) {
		fprintf(stderr, "Specify a user and only one command.\n");
		return 1;
	}

	if(strlen(argv[2]) > 900) {
		fprintf(stderr, "Command too long.\n");
		return 1;
	}

	if(strstr(argv[2],(strrchr(argv[0], '/')+1)) != NULL) {
		fprintf(stderr, "You can't use this binary\n");
		return 1;
	}

	struct passwd* pwd;
	if((pwd = getpwnam(argv[1])) == NULL) {
		fprintf(stderr, "User doesn't exist.\n");
		return 1;
	}

	char cmd[1024];
	sprintf(cmd, "sudo -u %s /bin/bash -c \"%s\"", argv[1], argv[2]);

	if(setgid(0) != 0) {
		fprintf(stderr, "Error on setting gid.\n");
		return 1;
	}
	if(setuid(0) != 0) {
                fprintf(stderr, "Error on setting uid.\n");
		return 1;
	}
	system(cmd);

	return 0;
}
