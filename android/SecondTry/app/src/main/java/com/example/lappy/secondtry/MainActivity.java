package com.example.lappy.secondtry;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;


public class MainActivity extends ActionBarActivity {

    public static final int FREE_RESPONSE = 997;
    public static final int MULTIPLE_CHOICE = 998;
    public static final int TRUE_FALSE = 999;
    public static final int QUESTION_TITLE_REQUEST_CODE = 1;
    public static final int SURVEY_TITLE_REQUEST_CODE = 2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        Button createSurvey = (Button)findViewById(R.id.create_survey);
        //Button viewSurvey = (Button)findViewById(R.id.view_survey);

        //createSurvey.setOnClickListener(createListener);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
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

    public void login(View v)
    {
        Intent goToLogin = new Intent(this, LoginCustomActivity.class);
        startActivity(goToLogin);
    };

}
