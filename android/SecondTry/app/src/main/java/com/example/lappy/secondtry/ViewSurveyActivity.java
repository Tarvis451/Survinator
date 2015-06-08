package com.example.lappy.secondtry;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;


public class ViewSurveyActivity extends ActionBarActivity {

    JSONArray master;
    ListView surveyList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_survey);
        surveyList = (ListView)findViewById(R.id.surveyListView);

        try{
            new OnlineHappiness().execute().get();
        }
        catch (Exception e){

        }
        finally {
            if(master!=null)
                fillInSurveyList(master);
        }

        surveyList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                try {
                    //Toast.makeText(getApplicationContext(),"zrad " + id + "stvuy " + master.getJSONObject(position).getInt("SurveyID"),Toast.LENGTH_LONG).show();
                    takeSurvey(master.getJSONObject(position).getInt("SurveyID"),master.getJSONObject(position).getString("SurveyName"));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_view_survey, menu);
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

    public void takeSurvey(int surveyid, String surveyname)
    {
        Intent i = new Intent(this, TakeSurveyActivity.class);
        i.putExtra("SurveyID",surveyid);
        i.putExtra("SurveyName",surveyname);
        startActivity(i);
    }

    protected void fillInSurveyList(JSONArray surveyInfo) {
        //ListView surveyList = (ListView)findViewById(R.id.surveyListView);
        String [] surveys = new String[]{"First Survey","Worst Survey","Cursed Survey","Burst Survey","Unrehearsed Survey"};
        ArrayList<String> arrayed = new ArrayList<String>();
        try {
            for(int i=0;i<surveyInfo.length();i++)
                arrayed.add(surveyInfo.getJSONObject(i).getString("SurveyName"));
        } catch (JSONException e) {
            e.printStackTrace();
        }
        //for(String s : surveys)
        //    arrayed.add(s);
        ListAdapter mAdapter = new ArrayAdapter<String>(getApplicationContext(),android.R.layout.simple_list_item_1, arrayed);
        surveyList.setAdapter(mAdapter);
    }

    private class OnlineHappiness extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            getSurveyList();
            //fillInSurveyList(null);
            return null;
        }

        protected void getSurveyList() {
            HttpClient httpClient = LoginCustomActivity.client;
            HttpGet httpGet = new HttpGet("http://travis-webserver.dyndns.org:81/php/getPublishedSurveys_android.php");
            //HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/login_android.php");

            final HttpResponse response;
            final HttpEntity httpEntity;

            //Toast.makeText(getApplicationContext(), "shrapnel!", Toast.LENGTH_LONG).show();

            //httpGet.getMethod();

            try {
                response = httpClient.execute(httpGet);
                httpEntity = response.getEntity();
            }
            catch(Exception e){
                //Toast.makeText(getApplicationContext(), "uh oh", Toast.LENGTH_LONG).show();
                //fillInSurveyList(null);
                return;
            }

            try {
                master = new JSONArray(EntityUtils.toString(httpEntity));
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

        }


    }
}
