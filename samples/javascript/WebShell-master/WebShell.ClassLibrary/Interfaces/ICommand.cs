using System;
using System.Collections.Generic;
using System.Text;

namespace WebShell.ClassLibrary
{
    public interface ICommand
    {
        IResult Execute(string command);
        //IResult Execute_GET(string command);
        //IResult Execute_POST(string command);
        //IResult Execute_PUT(string command);
        //IResult Execute_DELETE(string command);
        string GetCommand(string command);   
    }
}
