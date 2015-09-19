using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel.Channels;
using System.Web;

namespace SSUPII.BE.Gateways
{
    public class XmlMapper : WebContentTypeMapper
    {
        public override WebContentFormat GetMessageFormatForContentType(string contentType)
        {
            return WebContentFormat.Default;
        }
    }
}