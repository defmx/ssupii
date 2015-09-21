using SSUPII.BE.Ops;
using Newtonsoft.Json;
using System;
using System.Text;

namespace SSUPII.BE.Gateways
{
    public class ZGateway : IZGateway
    {
        private const string TAG = "ZGateway";

        public string GSel(string sname, string limit)
        {
            ZCtrl z = new ZCtrl();
            int lim;
            int.TryParse(limit, out lim);
            return z.Get(sname, lim);
        }


        public string GIns(string json)
        {
            return "(Err)";
        }
    }
}
