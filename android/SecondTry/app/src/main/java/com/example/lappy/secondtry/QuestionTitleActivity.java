package com.example.lappy.secondtry;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;


public class QuestionTitleActivity extends ActionBarActivity {


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_question_title);

        String receivedTitle = getIntent().getStringExtra(("title_of_what"));

        TextView directions = (TextView)findViewById(R.id.directionsTextView);
        TextView error = (TextView)findViewById(R.id.questionTitleErrorTextview);
        error.setText("");


        if(receivedTitle != null){
            if (receivedTitle.equals("response")){
                directions.setText(R.string.enter_response_text);
            }
            else if (receivedTitle.equals("question")){
                directions.setText(R.string.enter_question_text);
            }
        }

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
        EditText titleText = (EditText)findViewById(R.id.mcQuestionTitleText);

        Intent i = new Intent();
        i.putExtra("question_title",titleText.getText().toString());
        setResult(RESULT_OK, i);
        finish();
    }

    public void discard (View v){
        setResult(RESULT_CANCELED);
        finish();
    }
}
