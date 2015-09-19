using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.Serialization;
using System.Web;

namespace SSUPII.BE.Gateways.Data
{
    [DataContract(Namespace="http://bnkrs.dudlez.com/z")]
    public class Data
    {
        [DataMember]
        public string data { get; set; }
    }
}