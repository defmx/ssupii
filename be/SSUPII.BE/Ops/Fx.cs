using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Web;

namespace SSUPII.BE.Ops
{
    public class Fx
    {
        public static string DbStr(object o)
        {
            if (o == null)
            {
                return "null";
            }
            try
            {
                StringBuilder sb = new StringBuilder(o.ToString());
                sb.Replace(@"'", @"''");
                sb.Insert(0, '\'');
                sb.Insert(sb.Length, '\'');
                return sb.ToString();
            }
            catch (Exception)
            {
                return "null";
            }

        }

        public static string DbDate(object o)
        {
            if (o == null)
            {
                return "null";
            }
            StringBuilder sb;
            try
            {
                if (o.GetType() == typeof(DateTime))
                {
                    sb = new StringBuilder(((DateTime)o).ToString("yyyyMMdd"));
                }
                else
                {
                    if (o.GetType() == typeof(string))
                    {
                        string s = o as string;
                        if (s.Contains("T"))
                        {
                            s = s.Split('T')[0];
                        }
                        sb = new StringBuilder(DateTime.Parse(s).ToString("yyyyMMdd"));
                    }
                    else
                    {
                        sb = new StringBuilder();
                    }
                }
                sb.Insert(0, '\'');
                sb.Insert(sb.Length, '\'');
                return sb.ToString();
            }
            catch (Exception)
            {
                return "null";
            }

        }

        public static DataTable BuildDataTable(SqlDataReader reader)
        {
            DataTable dt = new DataTable();
            try
            {
                dt.Load(reader);
                foreach (System.Data.DataRow dr in dt.Rows)
                {
                    for (int i = 0; i < dr.ItemArray.Length; i++)
                    {
                        if (dr[i].GetType().Equals(typeof(string)) && dr[i].ToString().Contains(@""""))
                        {
                            dr[i]=dr[i].ToString().Replace(@"""","");
                        }

                    }
                }
                return dt;
            }
            catch (SqlException)
            {
                throw;
            }
        }

        public static DbType GetDbType(Type type)
        {
            if (type.Equals(typeof(short)))
            {
                return DbType.Int16;
            }
            if (type.Equals(typeof(int)))
            {
                return DbType.Int32;
            }
            if (type.Equals(typeof(long)))
            {
                return DbType.Int64;
            }
            if (type.Equals(typeof(string)))
            {
                return DbType.String;
            }
            if (type.Equals(typeof(float)) || type.Equals(typeof(double)))
            {
                return DbType.Double;
            }
            if (type.Equals(typeof(DateTime)))
            {
                return DbType.DateTime;
            }
            return DbType.String;
        }
    }

    
}