package com.example.lappy.secondtry;

import android.app.ListActivity;
import android.database.Cursor;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.ContextMenu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Adapter;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleCursorAdapter;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.concurrent.TimeUnit;

/**
 * Created by lappy on 5/25/15.
 */
public class ViewSurvey extends ListActivity {

    ListAdapter mAdapter;
    String whoa;
    JSONObject master;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //setContentView(R.layout.view_survey);

        //ListView lv = (ListView) findViewById(R.id.surveylist);

        String [] surveys = new String[]{"First Survey","Worst Survey","Cursed Survey","Burst Survey","Unrehearsed Survey"};
        ArrayList<String> arrayed = new ArrayList<String>();



        try {
            new OnlineHappiness().execute().get();
        }
        catch (Exception e){
            surveys[0]="you broke it!";
        }
        finally {
            try {
                //Thread.sleep(2000);
                if (whoa != null)
                    surveys[0]=whoa;
                else
                    surveys[0]="null bro";

                //JSONArray thing = master.getJSONArray("SurveyName");

                //for(int i=0;i<22;i++)
                    //arrayed.add(master.getString("SurveyName"));
                        //arrayed.add(Integer.toString(i));
                for(String s : surveys)
                    arrayed.add(s);

                mAdapter = new ArrayAdapter<String>(this,android.R.layout.simple_list_item_1, arrayed);
                setListAdapter(mAdapter);

                registerForContextMenu(this.getListView());
            }
            catch(Exception e){

            }
        }



        //
    }

    @Override
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);

        menu.add("View Results");
        menu.add("Take");
    }

    @Override
    protected void onListItemClick(ListView l, View v, int position, long id) {
        super.onListItemClick(l, v, position, id);

        l.showContextMenuForChild(v);
    }

    private class OnlineHappiness extends AsyncTask<String, Void, String>
    {

        @Override
        protected String doInBackground(String... params) {
            try{
                getSurveysFromInternet();
            }
            catch (Exception e ){

            }
            return null;
        }

        protected void getSurveysFromInternet() throws Exception{
            HttpClient httpClient = LoginCustomActivity.client;
            //HttpGet httpGet = new HttpGet("http://travis-webserver.dyndns.org:81/php/
            HttpPost httpGet = new HttpPost("http://travis-webserver.dyndns.org:81/php/getPublishedSurveys_android.php");


            final HttpResponse response;
            final HttpEntity httpEntity;

            try {
                response = httpClient.execute(httpGet);
                httpEntity = response.getEntity();
            }
            catch(Exception e){
                return;
            }



            JSONObject mainObject = new JSONObject(EntityUtils.toString(httpEntity));
            //JSONArray mainArray = new JSONArray(EntityUtils.toString(httpEntity));
            //JSONObject mainObjet = new JSONObject();

            //whoa=mainObject.toString();
            //master=mainObject;

            //whoa="fjfjf";
            //Thread.sleep(2000);
            whoa=EntityUtils.toString(httpEntity);
        }

    }
}
