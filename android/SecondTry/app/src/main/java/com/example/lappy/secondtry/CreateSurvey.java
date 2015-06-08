package com.example.lappy.secondtry;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

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
                mAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, questionTitleList);
                questionTitles.setAdapter(mAdapter);
            }
            else if (requestCode == MainActivity.SURVEY_TITLE_REQUEST_CODE){
                finish();
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
}
