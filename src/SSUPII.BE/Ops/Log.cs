using System;
using System.Diagnostics;

namespace SSUPII.BE.Ops
{
    public class Log
    {
        public enum Level
        {
            Err,
            Inf,
            Warn
        };

        public static void AddEntry(string tag, Level lvl, string message)
        {
            switch (lvl)
            {
                case Level.Err:
                    Trace.TraceError(tag + ":" + message);
                    break;
                case Level.Inf:
                    Trace.TraceInformation(tag + ":" + message);
                    break;
                case Level.Warn:
                    Trace.TraceWarning(tag + ":" + message);
                    break;
                default:
                    break;
            }
        }

        public static void AddEntry(string tag, string input, Exception ex)
        {
            Trace.TraceError(ex.Message);
            Trace.TraceError("Received input: \n" + input);
        }
    }
}
