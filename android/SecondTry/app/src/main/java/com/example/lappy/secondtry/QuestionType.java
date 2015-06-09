package com.example.lappy.secondtry;

import android.app.Notification;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.MenuItem;
import android.view.View;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by lappy on 5/27/15.
 */
public class QuestionType extends ActionBarActivity
{

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(resultCode == RESULT_OK){
            setResult(RESULT_OK,data);
            finish();
        }
    }

    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_question_type);
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

    public void trueFalse(View v)
    {
        Intent goToTrueFalse = //new Intent(this, TrueFalseActivity.class);
                new Intent(this, QuestionTitleActivity.class);
        goToTrueFalse.putExtra("question_type",MainActivity.TRUE_FALSE);
        goToTrueFalse.putExtra("title_of_what", "question");
        goToTrueFalse.putExtra("question_type","TF");
        startActivityForResult(goToTrueFalse, 1);
    }

    public void freeResponse(View v)
    {
        Intent goToFreeResponse = //new Intent(this, FreeResponseActivity.class);
                new Intent(this, QuestionTitleActivity.class);
        goToFreeResponse.putExtra("question_type",MainActivity.FREE_RESPONSE);
        goToFreeResponse.putExtra("title_of_what", "question");
        goToFreeResponse.putExtra("question_type","SA");
        startActivityForResult(goToFreeResponse, 1);
    }

    public void multipleChoice(View v)
    {
        Intent goToMultipleChoice = new Intent(this, MultipleChoiceActivity.class);
                //new Intent(this, QuestionTitleActivity.class);
        startActivityForResult(goToMultipleChoice, 1);
    }
}
