ALTER DATABASE [$(DatabaseName)]
    ADD LOG FILE (NAME = [WebNote_log], FILENAME = '$(Path1)WebNote_log.LDF', MAXSIZE = 2097152 MB, FILEGROWTH = 10 %);

