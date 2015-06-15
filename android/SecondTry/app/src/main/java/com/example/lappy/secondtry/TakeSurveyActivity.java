package com.example.lappy.secondtry;

import android.app.ActionBar;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;


public class TakeSurveyActivity extends ActionBarActivity {
    int surveyid;
    String surveyname;

    JSONArray questions;
    JSONArray responses;

    int pos=0;

    TextView surveyTitle;
    RelativeLayout rel;

    List<String> responsesToSend = new ArrayList<String>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_take_survey);

        Intent incoming = getIntent();

        surveyid = incoming.getIntExtra("SurveyID", -1);
        surveyname = incoming.getStringExtra("SurveyName");

        rel = (RelativeLayout)findViewById(R.id.takeSurveyLayout);

        //Draw survey title
        RelativeLayout.LayoutParams st = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        surveyTitle = new TextView(this);
        surveyTitle.setText(surveyname+Integer.toString(surveyid));
        surveyTitle.setTextSize(22);
        surveyTitle.setTextColor(Color.BLACK);
        surveyTitle.setLayoutParams(st);
        surveyTitle.setGravity(Gravity.CENTER_HORIZONTAL);
        st.addRule(RelativeLayout.ALIGN_PARENT_TOP);
        surveyTitle.setId(1);
        rel.addView(surveyTitle);

        //Get question list
        try {
            new GoOnline().execute().get();
        } catch (Exception e) {
            e.printStackTrace();
            return;
        }
        finally{
            drawQuestion();
        }

        /*final RelativeLayout rel = (RelativeLayout)findViewById(R.id.takeSurveyLayout);
        RelativeLayout.LayoutParams lp = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        final Button hello = new Button(this);
        hello.setText("asdfjklf");
        rel.addView(hello, lp);
        //rel.removeView(hello);
        hello.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                rel.removeView(hello);
            }
        });*/

        String[] responsesToSend;

        //drawQuestion();
    }

    public void drawQuestion()
    {
        if(questions == null){
            Toast.makeText(getApplicationContext(),"This survey has no questions! Please go back.",Toast.LENGTH_LONG).show();
            return;
        }

        final List<View> viewsToKill = new ArrayList<View>();

        //Draw question title
        String qtitle="";
        try {
            qtitle = questions.getJSONObject(pos).getString("QuestionText");
        } catch (JSONException e) {
            e.printStackTrace();
        }
        TextView questionTitle = new TextView(getApplicationContext());
        RelativeLayout.LayoutParams qt = new RelativeLayout.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
        qt.addRule(RelativeLayout.BELOW, surveyTitle.getId());
        questionTitle.setText(qtitle);
        questionTitle.setTextColor(Color.BLACK);
        questionTitle.setGravity(Gravity.CENTER_HORIZONTAL);
        questionTitle.setId(2);
        questionTitle.setLayoutParams(qt);
        rel.addView(questionTitle);
        viewsToKill.add(questionTitle);


        //Get question type
        String type="";
        try {
            type = questions.getJSONObject(pos).getString("QuestionType");
        } catch (JSONException e) {
            e.printStackTrace();
            return;
        }

        //Depending on type, draw question and response
        if(type.equals("TF"))
        {
             //Draw true button
            Button trueButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams tb = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            tb.addRule(RelativeLayout.BELOW, questionTitle.getId());
            trueButton.setId(3);
            //trueButton.setGravity(Gravity.CENTER_HORIZONTAL);
            trueButton.setText("true");
            trueButton.setLayoutParams(tb);
            rel.addView(trueButton);
            viewsToKill.add(trueButton);
            trueButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("1");
                    advance();
                }
            });


            //Draw false button
            Button falseButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams fb = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            fb.addRule(RelativeLayout.BELOW, trueButton.getId());
            //falseButton.setGravity(Gravity.CENTER_HORIZONTAL);
            falseButton.setText("false");
            falseButton.setLayoutParams(fb);
            rel.addView(falseButton);
            viewsToKill.add(falseButton);
            falseButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("2");
                    advance();
                }
            });
        }
        else if(type.equals("SA"))
        {
            //Draw free response text box
            final EditText saText = new EditText(getApplicationContext());
            RelativeLayout.LayoutParams sat = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.MATCH_PARENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            sat.addRule(RelativeLayout.BELOW,questionTitle.getId());
            saText.setGravity(Gravity.CENTER_HORIZONTAL);
            saText.setLayoutParams(sat);
            saText.setId(22);
            saText.setTextColor(Color.BLACK);
            rel.addView(saText);
            viewsToKill.add(saText);

            //Draw submit button
            Button submit = new Button(getApplicationContext());
            RelativeLayout.LayoutParams sb = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            sb.addRule(RelativeLayout.BELOW,saText.getId());
            submit.setGravity(Gravity.CENTER_HORIZONTAL);
            submit.setText("submit");
            submit.setLayoutParams(sb);
            rel.addView(submit);
            viewsToKill.add(submit);
            submit.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add(saText.getText().toString());
                    advance();
                }
            });
        }
        else if(type.equals("MC"))
        {
            try {
                new GetResponse().execute(Integer.toString(pos+1)).get();
            } catch (Exception e) {
                e.printStackTrace();
                return;
            }

            if(responses==null){
                Toast.makeText(getApplicationContext(),"Something went wrong. GG.",Toast.LENGTH_LONG).show();
                return;
            }

            int numQuestions = responses.length();
            final int arbitraryIDNumber = 172;

            for(int j=0;j<numQuestions;j++)
            {
                Button tmpButton = new Button(getApplicationContext());
                RelativeLayout.LayoutParams tmpParams = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
                if(j==0){
                    tmpParams.addRule(RelativeLayout.BELOW, questionTitle.getId());
                }
                else
                {
                    tmpParams.addRule(RelativeLayout.BELOW, arbitraryIDNumber+j);
                }
                tmpButton.setGravity(Gravity.CENTER_HORIZONTAL);
                try {
                    tmpButton.setText(responses.getJSONObject(j).getString("ResponseText"));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                tmpButton.setId(arbitraryIDNumber+j+1);
                tmpButton.setLayoutParams(tmpParams);
                rel.addView(tmpButton);
                viewsToKill.add(tmpButton);
                final int jj=j;
                tmpButton.setOnClickListener(new View.OnClickListener(){
                    @Override
                    public void onClick(View v){
                        destroyViews(viewsToKill);
                        responsesToSend.add(Integer.toString(jj+1));
                        advance();
                    }
                });
            }

            /*
            //Draw a button
            Button aButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams ab = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            ab.addRule(RelativeLayout.BELOW, questionTitle.getId());
            aButton.setGravity(Gravity.CENTER_HORIZONTAL);
            try {
                aButton.setText(responses.getJSONObject(0).getString("ResponseText"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
            aButton.setId(343);
            aButton.setLayoutParams(ab);
            rel.addView(aButton);
            viewsToKill.add(aButton);
            aButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("1");
                    advance();
                }
            });

            //Draw b button
            Button bButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams bb = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            bb.addRule(RelativeLayout.BELOW, aButton.getId());
            bButton.setGravity(Gravity.CENTER_HORIZONTAL);
            try {
                bButton.setText(responses.getJSONObject(1).getString("ResponseText"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
            bButton.setId(282);
            bButton.setLayoutParams(bb);
            rel.addView(bButton);
            viewsToKill.add(bButton);
            bButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("2");
                    advance();
                }
            });

            //Draw c button
            Button cButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams cb = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            cb.addRule(RelativeLayout.BELOW, bButton.getId());
            cButton.setGravity(Gravity.CENTER_HORIZONTAL);
            try {
                cButton.setText(responses.getJSONObject(2).getString("ResponseText"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
            cButton.setId(331);
            cButton.setLayoutParams(cb);
            rel.addView(cButton);
            viewsToKill.add(cButton);
            cButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("3");
                    advance();
                }
            });


            //Draw d button
            Button dButton = new Button(getApplicationContext());
            RelativeLayout.LayoutParams db = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.WRAP_CONTENT, RelativeLayout.LayoutParams.WRAP_CONTENT);
            db.addRule(RelativeLayout.BELOW,cButton.getId());
            dButton.setGravity(Gravity.CENTER_HORIZONTAL);
            try {
                dButton.setText(responses.getJSONObject(3).getString("ResponseText"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
            dButton.setLayoutParams(db);
            rel.addView(dButton);
            viewsToKill.add(dButton);
            dButton.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    destroyViews(viewsToKill);
                    responsesToSend.add("4");
                    advance();
                }
            });
            */
        }
    }

    public void destroyViews(List<View> viewList)
    {
        if(viewList==null)
            return;

        for(int i=0;i<viewList.size();i++)
            rel.removeView(viewList.get(i));
    }

    public void advance()
    {
        pos++;
        if(pos >= questions.length()){
            Toast.makeText(getApplicationContext(),"Survey finished. Thank you!", Toast.LENGTH_LONG).show();
            sendResults();
        }
        else
        {
            //Toast.makeText(getApplicationContext(),"pos="+pos+" qlen="+questions.length(), Toast.LENGTH_LONG).show();
            drawQuestion();
        }
    }

    public void sendResults()
    {
        for(int i=0;i<responsesToSend.size();i++){
            String qid="";
            try {
                qid = questions.getJSONObject(i).getString("QuestionID");
            } catch (JSONException e) {
                e.printStackTrace();
                Toast.makeText(getApplicationContext(),"something bad",Toast.LENGTH_LONG);
            }
            String[] parappa = new String[]{Integer.toString(surveyid),qid,responsesToSend.get(i)};
            try {
                new SendResults().execute(parappa).get();
            } catch (InterruptedException e) {
                e.printStackTrace();
            } catch (ExecutionException e) {
                e.printStackTrace();
            }
        }
        finish();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_take_survey, menu);
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

    protected class GoOnline extends AsyncTask<String, Void, String>
    {
        HttpClient httpClient = LoginCustomActivity.client;

        @Override
        protected String doInBackground(String... params)
        {
            getQuestions();
            return null;
        }

        protected void getQuestions()
        {
            HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/getQuestions_android.php");

            List<NameValuePair> nvp = new ArrayList<NameValuePair>();
            nvp.add(new BasicNameValuePair("SurveyID", Integer.toString(surveyid)));

            try {
                httpPost.setEntity(new UrlEncodedFormEntity(nvp));
            } catch (UnsupportedEncodingException e) {
                e.printStackTrace();
                return;
            }


            HttpResponse httpResponse;
            final HttpEntity resEntity;
            try {
                httpResponse = httpClient.execute(httpPost);
                resEntity = httpResponse.getEntity();
            } catch (IOException e) {
                e.printStackTrace();
                return;
            }



            try {
                questions = new JSONArray(EntityUtils.toString(resEntity));
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    protected class GetResponse extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... params) {
            getResponse(Integer.parseInt(params[0]));
            return null;
        }

        protected void getResponse(int qid)
        {
            HttpClient httpClient = LoginCustomActivity.client;
            HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/getResponses_android.php");

            List<NameValuePair> nvp = new ArrayList<NameValuePair>();
            nvp.add(new BasicNameValuePair("SurveyID",Integer.toString(surveyid)));
            nvp.add(new BasicNameValuePair("QuestionID",Integer.toString(qid)));

            try {
                httpPost.setEntity(new UrlEncodedFormEntity(nvp));
            } catch (Exception e) {
                e.printStackTrace();
            }

            HttpResponse httpResonse;

            try {
                httpResonse=httpClient.execute(httpPost);
            } catch (IOException e) {
                e.printStackTrace();
                return;
            }

            HttpEntity httpEntity = httpResonse.getEntity();

            //final JSONArray tmp_responses;


            try {
                responses=new JSONArray(EntityUtils.toString(httpEntity));
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    protected class SendResults extends AsyncTask<String, Void, String>
    {
        @Override
        protected String doInBackground(String... params) {
            submitResponse(params[0],params[1],params[2]);
            return null;
        }

        protected void submitResponse(String surveyid, String qid, String resp)
        {
            HttpClient httpClient = LoginCustomActivity.client;
            HttpPost httpPost = new HttpPost("http://travis-webserver.dyndns.org:81/php/submitResponse_android.php");

            List<NameValuePair> nvp = new ArrayList<NameValuePair>();
            nvp.add(new BasicNameValuePair("SurveyID",surveyid));
            nvp.add(new BasicNameValuePair("QuestionID",qid));
            nvp.add(new BasicNameValuePair("Response",resp));

            try {
                httpPost.setEntity(new UrlEncodedFormEntity(nvp));
            } catch (UnsupportedEncodingException e) {
                e.printStackTrace();
            }

            try {
                httpClient.execute(httpPost);
            } catch (IOException e) {
                Toast.makeText(getApplicationContext(),"you LOSE",Toast.LENGTH_LONG);
                e.printStackTrace();
            }
        }
    }
}
