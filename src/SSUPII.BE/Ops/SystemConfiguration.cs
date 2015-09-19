using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Web.Configuration;

namespace SSUPII.BE.Ops
{
    [Serializable()]
    public class SystemConfiguration
    {
        private const string _vCode = "30ed80ea7e3b44ab8a40dd4abf7ca679";
        public string VerificationCode { get { return _vCode; } set { if (value != _vCode) { throw new SystemException("Verification error"); } } }
        public string DbUser { get; set; }
        public string DbSchema { get; set; }
        public string DbServer { get; set; }
        public string DbPassword { get; set; }
        public static int DbBatchSize
        {
            get
            {
                return Int32.Parse(ConfigurationManager.AppSettings["DbBatchSize"]);
            }
        }
    }
}