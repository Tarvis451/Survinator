package com.example.lappy.secondtry;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class SurveyTitleActivity extends ActionBarActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_survey_title);

        TextView directions = (TextView)findViewById(R.id.directionsTextView);
        directions.setText(R.string.enter_survey_title_text);

        TextView errorBox = (TextView)findViewById(R.id.questionTitleErrorTextview);
        errorBox.setText("");
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_question_title, menu);
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

    public void saveTitle (View v) {
        //Intent i = new Intent();
        //i.putExtra("question_title",titleText.getText().toString());
        //setResult(RESULT_OK, i);
        //finish();
        try {
            new SaveSurveyTitleOnline().execute();
        }
        catch (Exception e){

        }
    }

    public void finishUp(int survey_id){
        Intent i = new Intent();
        i.putExtra("survey_id",survey_id);
        setResult(RESULT_OK, i);
        finish();
    }

    public void discard (View v){
        setResult(RESULT_CANCELED);
        finish();
    }

    private class SaveSurveyTitleOnline extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... params) {
            boolean didItWork = false;
            try {
                talkToServer();
            }
            catch (Exception e){

            }
            return null;
        }

        public void talkToServer() throws Exception {
            final EditText surveyTitleText = (EditText)findViewById(R.id.mcQuestionTitleText);
            final TextView errorBox  = (TextView)findViewById(R.id.questionTitleErrorTextview);
            final EditText surveyDescText = (EditText)findViewById(R.id.surveyDescriptionEditText);

            errorBox.post(new Runnable(){
                public void run(){
                    errorBox.setText("Connecting...");
                }
            });

            //Open a connection
            HttpClient httpClient = LoginCustomActivity.client;
            HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/createsurvey_android.php");

            //Build the data
            List<NameValuePair> nameValuePairList = new ArrayList<NameValuePair>();
            nameValuePairList.add(new BasicNameValuePair("title",surveyTitleText.getText().toString()));
            nameValuePairList.add(new BasicNameValuePair("description",surveyDescText.getText().toString()));

            //Post the data
            httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairList));



            //Get a response
            final HttpResponse response;
            final HttpEntity resEntity;

            try{
                response = httpClient.execute(httpPost);
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
                    errorBox.setText("Decoding server response...");
                }
            });

            //convert httpentity to json
            JSONObject mainObject = new JSONObject(EntityUtils.toString(resEntity));

            //decode everything
            final int errcode = mainObject.getInt("error");
            final String okay = mainObject.getString("message");
            //final String okay = mainObject.toString();
            //final String okay = EntityUtils.toString(resEntity);
            //final String okay = "okay";

            //update with response
            errorBox.post(new Runnable(){
                public void run(){
                    errorBox.setText(okay);
                }
            });

            Thread.sleep(2000);

            //success?
            if (errcode == 0)
            {
                finishUp(mainObject.getInt("survey_id"));
            }
        }
    }
}
