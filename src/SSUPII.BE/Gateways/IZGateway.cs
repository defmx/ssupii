using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;

namespace SSUPII.BE.Gateways
{
    [ServiceContract]
    public interface IZGateway
    {
        #region "GET methods"

        [OperationContract]
        [WebInvoke(Method = "GET", UriTemplate = "s?t={sname}&l={limit}", BodyStyle = WebMessageBodyStyle.Bare, ResponseFormat = WebMessageFormat.Json)]
        string GSel(string sname, string limit);

        #endregion

        #region "POST methods"

        [OperationContract]
        [WebInvoke(Method = "POST", UriTemplate = "i", RequestFormat = WebMessageFormat.Json, ResponseFormat = WebMessageFormat.Json)]
        string GIns(string json);

        #endregion
    }

}
