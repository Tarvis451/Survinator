package com.example.lappy.secondtry;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONObject;
import org.json.JSONTokener;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;


public class LoginCustomActivity extends ActionBarActivity {

    public static HttpClient client;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_custom);


    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login_custom, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public void loginToServer(View v){
        try {
            new DoStuffOnline().execute("http://travis-webserver.dyndns.org:81/php/login_android.php");
            //new DoStuffOnline().execute("http://192.168.1.105/php/login_android.php");
        }
        catch (Exception e){

        }
    }

    public void registerToServer(View v){
        try {
            new DoStuffOnline().execute("http://travis-webserver.dyndns.org:81/php/newuser_android.php");
            //new DoStuffOnline().execute("http://192.168.1.105/php/newuser_android.php");
        }
        catch (Exception e){

        }
    }

    public void mainMenu(int userid, String username){
        Intent goToMainMenu = new Intent(this, MainMenuActivity.class);
        goToMainMenu.putExtra("user_id",userid);
        goToMainMenu.putExtra("username",username);
        startActivity(goToMainMenu);
    }

    private class DoStuffOnline extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            try {
                talkToServer(params[0]);
            }
            catch (Exception e){

            }
            return null;
        }

        public void talkToServer(String urlString) throws Exception {
            final EditText username = (EditText)findViewById(R.id.usernameText);
            final EditText password = (EditText)findViewById(R.id.passwordText);
            final TextView errorBox = (TextView)findViewById(R.id.errorBox);


            errorBox.post(new Runnable(){
                public void run(){
                    errorBox.setText("Connecting...");
                }
            });

            client = new DefaultHttpClient();
            HttpPost post = new HttpPost(urlString);

            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
            nameValuePairs.add(new BasicNameValuePair("username", username.getText().toString()));
            nameValuePairs.add(new BasicNameValuePair("password", password.getText().toString()));

            post.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            final HttpResponse response;
            final HttpEntity resEntity;

            try{
                response = client.execute(post);
                resEntity = response.getEntity();
            }
            catch(Exception e){
                errorBox.post(new Runnable(){
                    public void run(){
                        errorBox.setText("error during post");
                    }
                });
                return;
            }

            errorBox.post(new Runnable(){
                public void run(){
                    errorBox.setText("Holding onto the dream...");
                }
            });

            //Convert http entity to JSON
            JSONObject mainObject = new JSONObject(EntityUtils.toString(resEntity));


            final int errcode = mainObject.getInt("error");

            final String okay = mainObject.getString("message");

            errorBox.post(new Runnable() {
                public void run() {
                    errorBox.setText(okay);
                }
            });

            if(errcode == 0)
                mainMenu(mainObject.getInt("userid"),username.getText().toString());
        }
    }
}
