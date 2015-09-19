using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Security;
using System.Web;

namespace SSUPII.BE.Ops
{
    public class DbCtrl
    {
        public SqlConnection SqlConnection { get; private set; }

        public DbCtrl(string cxStr)
        {
            SqlConnectionStringBuilder cs = new SqlConnectionStringBuilder(cxStr);
            int[] i = { 106, 119, 119, 115, 119, 119, 36, 36, 49 };
            SecureString secstr = new SecureString();
            SqlCredential crd;

            foreach (int w in i)
            {
                secstr.AppendChar((char)w);
            }
            secstr.MakeReadOnly();
            crd = new SqlCredential("dudbdsa@x6o4b47nk5", secstr);
            try
            {
                SqlConnection = new SqlConnection(cs.ToString());
                SqlConnection.Credential = crd;
                SqlConnection.Open();
            }
            catch (Exception)
            {
                throw;
            }
        }

        public DbCtrl(string cxStr, SqlCredential crd)
        {
            try
            {
                SqlConnection = new SqlConnection(cxStr);
                SqlConnection.Credential = crd;
                SqlConnection.Open();
            }
            catch (Exception)
            {
                throw;
            }
        }

        ~DbCtrl()
        {
            try
            {
                SqlConnection.Close();
            }
            catch { }

        }

        public void NonQuery(string query)
        {
            SqlCommand sqlComm;
            try
            {
                sqlComm = new SqlCommand(query, SqlConnection);
                sqlComm.ExecuteNonQuery();
            }
            catch (SqlException)
            {
                throw;
            }
        }

        public DataTable Query(string query)
        {
            SqlCommand sqlComm;
            SqlDataReader sqlRdr = null;

            try
            {
                sqlComm = new SqlCommand(query, SqlConnection);
                sqlRdr = sqlComm.ExecuteReader();

                DataTable dt =new DataTable();
                dt.Load(sqlRdr);

                return dt;
            }
            catch (SqlException)
            {
                throw;
            }
        }

        public T RetrieveSingleObject<T>(bool isParameterizedQuery, params KeyValuePair<string, object>[] queryParameters)
    where T : new()
        {
            SqlCommand sqlComm;
            SqlDataReader sqlRdr = null;

            try
            {
                sqlComm = new SqlCommand("", SqlConnection);
                if (isParameterizedQuery)
                {
                    foreach (var p in queryParameters)
                    {
                        sqlComm.Parameters.AddWithValue("@" + p.Key.Replace("@", ""), p.Value).DbType = Fx.GetDbType(p.Value.GetType());
                    }
                }
                else
                {
                    List<string> wlist = new List<string>();
                    foreach (var p in queryParameters)
                    {
                        wlist.Add(p.Value.ToString());
                    }
                    sqlComm.CommandText = string.Format(sqlComm.CommandText, wlist.ToArray());
                }

                sqlRdr = sqlComm.ExecuteReader(CommandBehavior.CloseConnection);
                T t = new T();
                do
                {
                    while (sqlRdr.Read())
                    {
                        foreach (System.Reflection.PropertyInfo pinfo in typeof(T).GetProperties())
                        {
                            try
                            {
                                object v = sqlRdr[pinfo.Name];
                                if (v.GetType().Equals(typeof(DBNull)))
                                {
                                    pinfo.SetValue(t, string.Empty);
                                }
                                else
                                {
                                    pinfo.SetValue(t, v);
                                }
                            }
                            catch (IndexOutOfRangeException)
                            {
                            }
                        }
                    }
                } while (sqlRdr.NextResult());
                return t;
            }
            catch (SqlException)
            {
                return default(T);
            }
            finally
            {
                if (sqlRdr != null) sqlRdr.Close();
            }
        }


    }
}