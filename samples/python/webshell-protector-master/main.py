import winappdbg


class DebugEvents(winappdbg.EventHandler):
    """
    Event handler class.
    event: https://github.com/MarioVilas/winappdbg/blob/master/winappdbg/event.py
    """

    apiHooks = {
        'kernel32.dll': [
            ("CreateProcessW", 10)
        ]
    }

    def pre_CreateProcessW(self, event, ra, lpApplicationName, lpCommandLine, lpProcessAttributes, lpThreadAttributes,
                           bInheritHandles, dwCreationFlags, lpEnvironment, lpCurrentDirectory, lpStartupInfo,
                           lpProcessInformation):

        cmd = event.get_process().peek_string(lpCommandLine, fUnicode=True)

        print('New process: {}'.format(cmd))

        if cmd.startswith(u'C:\\Windows\\system32\\cmd.exe'):
            print('Intercepting suspicious process!')
            # Get the thread that hit the breakpoint
            thread = event.get_thread()

            # Set a new value for the RDX register, so it does not execute!
            # RDX contains the lpCommandLine parameter, therefor
            thread.set_register('Rdx', 0x0)


def main():
    myevent = DebugEvents()

    debug = winappdbg.Debug(myevent)

    try:
        debug.system.scan()
        for (process, name) in debug.system.find_processes_by_filename('w3wp.exe'):
            print "Found %d, %s" % (process.get_pid(),
                                    process.get_filename())

            debug.attach(process.get_pid())

            print "Attached to %d-%s" % (process.get_pid(),
                                         process.get_filename())

        debug.loop()

    finally:
        debug.stop()

    exit()


if __name__ == '__main__':
    main()

