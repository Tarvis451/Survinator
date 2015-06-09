package com.example.lappy.secondtry;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.message.BasicNameValuePair;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;
import java.util.concurrent.ExecutionException;
import java.util.jar.Attributes;

/**
 * Created by lappy on 5/25/15.
 */
public class CreateSurvey extends ActionBarActivity
{
    List<Question> questionList = new ArrayList<Question>();
    ListAdapter mAdapter;
    List<String> questionTitleList = new ArrayList<String>();

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data)
    {
        ListView questionTitles = (ListView)findViewById(R.id.questionTitles);

        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == RESULT_OK)
        {
            if(requestCode == MainActivity.QUESTION_TITLE_REQUEST_CODE) {
                questionTitleList.add(data.getStringExtra(("question_title")));
                String question_type = data.getStringExtra("question_type");
                if(question_type.equals("MC"))
                {
                    questionList.add(new Question(data.getStringExtra("question_title"),data.getStringExtra("question_type"),data.getStringArrayListExtra("mc_responses")));
                }
                else
                {
                    questionList.add(new Question(data.getStringExtra("question_title"),data.getStringExtra("question_type")));
                }
                //questionList.add(new Question(data.getStringExtra("question_title"),data.getStringExtra("question_type")))
                mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, questionTitleList);
                questionTitles.setAdapter(mAdapter);
            }
            else if (requestCode == MainActivity.SURVEY_TITLE_REQUEST_CODE){
                try {
                    new FinishCreatingSurvey().execute(Integer.toString(data.getIntExtra("survey_id",-1))).get();
                } catch (InterruptedException e) {
                    e.printStackTrace();
                } catch (ExecutionException e) {
                    e.printStackTrace();
                }
                finally{
                    finish();
                }

            }
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);

        Intent incoming = getIntent();
        setContentView(R.layout.activity_create_survey);
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings)
        {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public void questionType(View v)
    {
        Intent goToPickQuestion = new Intent(this, QuestionType.class);
                //new Intent(this,QuestionTitleActivity.class);
        startActivityForResult(goToPickQuestion, MainActivity.QUESTION_TITLE_REQUEST_CODE);
    }

    public void saveSurvey(View v)
    {
        Intent goToPickSurveyTitle = new Intent(this, SurveyTitleActivity.class);
        startActivityForResult(goToPickSurveyTitle,MainActivity.SURVEY_TITLE_REQUEST_CODE);
    }

    protected class FinishCreatingSurvey extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... params) {
            sendItOff(params[0]);
            return null;
        }

        protected void sendItOff(String surveyid)
        {
            HttpClient httpClient = LoginCustomActivity.client;


            for(int i=0;i<questionList.size();i++)
            {
                HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/addQuestion_android.php");


                //debug mode
                //Toast.makeText(getApplicationContext(),"we have "+questionList.size(),Toast.LENGTH_LONG);


                List<NameValuePair> nvp = new ArrayList<NameValuePair>();
                nvp.add(new BasicNameValuePair("SurveyID",surveyid));
                nvp.add(new BasicNameValuePair("QuestionTitle",questionList.get(i).getTitle()));
                nvp.add(new BasicNameValuePair("QuestionType",questionList.get(i).getType()));
                if(questionList.get(i).getType().equals("MC"))
                {
                    nvp.add(new BasicNameValuePair("r1",questionList.get(i).getMultipleChoiceText().get(0)));
                    nvp.add(new BasicNameValuePair("r2",questionList.get(i).getMultipleChoiceText().get(1)));
                    nvp.add(new BasicNameValuePair("r3",questionList.get(i).getMultipleChoiceText().get(2)));
                    nvp.add(new BasicNameValuePair("r4",questionList.get(i).getMultipleChoiceText().get(3)));
                }

                try {
                    httpPost.setEntity(new UrlEncodedFormEntity(nvp));
                } catch (UnsupportedEncodingException e) {
                    e.printStackTrace();
                }

                try {
                    httpClient.execute(httpPost);
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }

        }
    }
}
