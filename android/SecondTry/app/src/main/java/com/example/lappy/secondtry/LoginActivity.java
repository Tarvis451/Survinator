package com.example.lappy.secondtry;

import android.app.Notification;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.View;

/**
 * Created by lappy on 5/26/15.
 */
public class LoginActivity extends ActionBarActivity
{
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
    }

    public void createSurvey(View v)
    {
        Intent goToCreate = new Intent(this, CreateSurvey.class);
        startActivity(goToCreate);
    };
}
