using SSUPII.BE.Ops.Resources;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Data;
using System.IO;
using System.Reflection;
using System.Text;
using System.Linq;

namespace SSUPII.BE.Ops
{
    public class ZCtrl
    {
        private DbCtrl _dbctrl;
        private const string TAG = "ZIntf";

        public ZCtrl()
        {
            _dbctrl = new DbCtrl(Properties.Settings.Default.AzureSQLCx);

        }

        #region "WebMethods backend"

        internal string Get(string sname, int lim)
        {
            DataTable dt = _dbctrl.Query("SELECT id,name FROM cSch");
            List<Obj.Scholarship> list = new List<Obj.Scholarship>();
            foreach (DataRow r in dt.Rows)
            {
                Obj.Scholarship s = new Obj.Scholarship();
                s.Name = r.ItemArray[1].ToString();
                list.Add(s);
            }
            return JsonConvert.SerializeObject(list);
        }

        #endregion

        #region "private functions"

        #endregion





    }
}