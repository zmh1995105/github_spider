using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebNote.DB;
using System.Data;
using System.Web.Script.Serialization;

namespace WebNote.DB.Business
{
    public static class WebNoteBiz
    {
        public static long AddUser(string email, string password)
        {
            long userId;
            WNDataContext db = new WNDataContext();
            User user = new User();
            user.Email = email;
            user.Name = email.Split('@').Length>0?email.Split('@')[0]:"*";
            user.Password = EncDec.Encrypt(password, "webnote");
            UserRole uroles = new UserRole();
            uroles.User = user;
            uroles.RoleId = 1;
            db.UserRoles.InsertOnSubmit(uroles);
            db.SubmitChanges();

            userId = user.Id;

            return userId;
        }

        public static bool IsValidPassword(string email, string password,out long userId)
        {
            bool result = false;
            WNDataContext db = new WNDataContext();
            try
            {
                User user = db.Users.Single(u => u.Email == email);
                userId = user.Id;

                string dbPwd = EncDec.Decrypt(user.Password, "webnote");
                if (dbPwd == password) result = true;
                else result = false;
            }
            catch (System.InvalidOperationException)
            {
                userId = -1;
                result = false;
                //TODO: log error 
            }
            catch(Exception e)
            {
                throw e;
            }

            return result;
        }

        public static bool AdNote(long userId, string title, bool isPublic, string tag, string content)
        {
            try
            {
                WNDataContext db = new WNDataContext();
                Note note = new Note();
                note.user_Id = userId;
                note.title = title;
                note.isPublic = isPublic;
                note.content = content;
                note.creation_date = DateTime.Now;
                note.last_update = DateTime.Now;

                db.Notes.InsertOnSubmit(note);
                db.SubmitChanges();
                return true;
            }
            catch (Exception e)
            { 
                //TODO: log error -> medium
                return false;
            }
        }

        public static string GetUserNotes(long userId)
        {
            WNDataContext db = new WNDataContext();
            JavaScriptSerializer js = new JavaScriptSerializer();
            var result = from note in db.Notes where note.user_Id == userId select note;
            string strJsonResult = "{\"items\":[";
            foreach (var r in result)
            {
                strJsonResult += "{\"id\":" + r.id + ",\"title\":\"" + r.title + "\",\"content\":\""
                    + r.content.Replace("\"", "&#34;") + "\",\"date\":\"" + r.creation_date + "\"},";
            }
            strJsonResult = strJsonResult.Remove(strJsonResult.Length - 1, 1);
            strJsonResult = strJsonResult + "]}";
            strJsonResult = strJsonResult.Replace("\r", "");
            strJsonResult = strJsonResult.Replace("\n", "");
            return strJsonResult;
        }

        public static string SearchNotes(string query)
        {
            WNDataContext db = new WNDataContext();
            JavaScriptSerializer js = new JavaScriptSerializer();
            string sqlQuery = "select * from note where ispublic=1 and (";
            foreach (string str in query.Split(' '))
            {
                string word = str;
                if (word.EndsWith("s")) word = str.Remove(word.Length - 1);
                sqlQuery += " title like \'%" + word + "%\' or";
                sqlQuery += " content like \'%" + word + "%\' or";
            }
            sqlQuery = sqlQuery.Remove(sqlQuery.Length - 2);
            sqlQuery += ")";
            IEnumerable<Note> result = db.ExecuteQuery<Note>(sqlQuery);

            string strJsonResult = "{\"items\":[";
            foreach (var r in result)
            {
                strJsonResult += "{\"id\":" + r.id + ",\"title\":\"" + r.title + "\",\"content\":\""
                    + r.content.Replace("\"", "&#34;") + "\",\"date\":\"" + r.creation_date + "\"},";
            }
            strJsonResult = strJsonResult.Remove(strJsonResult.Length - 1, 1);
            strJsonResult = strJsonResult + "]}";
            strJsonResult = strJsonResult.Replace("\r", "");
            strJsonResult = strJsonResult.Replace("\n", "");
            return strJsonResult;
        }

        public static string GetNote(long id)
        {
            Note note = null;
            string strJsonResult = string.Empty;
            WNDataContext db = new WNDataContext();
            try
            {
                note = db.Notes.Single(n => n.id == id);
                strJsonResult = "{\"id\":\"" + note.id + "\", \"title\":\"" + note.title + "\", \"content\":\"" + note.content.Replace("\"", "&#34;") + "\"}";
                strJsonResult = strJsonResult.Replace("\r", "");
                strJsonResult = strJsonResult.Replace("\n", "");
            }
            catch (Exception e) 
            {
                //TODO: log error => medium
            }

            return strJsonResult;
        }

        public static bool EditNote(long NoteId, long UserId, string Title,bool isPublic, string Tag, string NoteText)
        {
            bool result = false;
            try
            {
                WNDataContext db = new WNDataContext();
                Note note = db.Notes.Single(n => n.id == NoteId);
                note.title = Title;
                note.isPublic = isPublic;
                note.content = NoteText;
                note.last_update = DateTime.Now;
                db.SubmitChanges();
                result = true;
            }
            catch { result = false; }

            return result;
        }

        public static bool DeleteNote(long NoteId)
        {
            bool result = false;
            try
            {
                WNDataContext db = new WNDataContext();
                db.Notes.DeleteOnSubmit(db.Notes.Single(n => n.id == NoteId));
                db.SubmitChanges();
                result = true;
            }
            catch { result = false; }

            return result;
        }
    }
}
