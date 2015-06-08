package com.example.lappy.secondtry;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.List;


public class MultipleChoiceActivity extends ActionBarActivity {
    ListAdapter mAdapter;
    ArrayList<String> responseTitleList = new ArrayList<String>();

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        ListView responseTitlesView = (ListView)findViewById(R.id.responseTitlesView);

        if(resultCode == RESULT_OK){
            responseTitleList.add(data.getStringExtra(("question_title").toString()));
            mAdapter=new ArrayAdapter<String>(this,android.R.layout.simple_list_item_checked, responseTitleList);
            responseTitlesView.setAdapter(mAdapter);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_multiple_choice);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_multiple_choice, menu);
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

    public void responseTitle(View v){
        Intent goToResponseTitle = new Intent(this, QuestionTitleActivity.class);
        goToResponseTitle.putExtra("title_of_what","response");
        startActivityForResult(goToResponseTitle,1);
    }

    public void save(View v){
        EditText questionTitle = (EditText)findViewById(R.id.mcQuestionTitleText);

        Intent i = new Intent();
        i.putExtra("question_title",questionTitle.getText().toString());
        i.putStringArrayListExtra("mc_responses",responseTitleList);
        setResult(RESULT_OK, i);
        finish();
    }

    public void discard(View v){
        setResult(RESULT_CANCELED);
        finish();
    }
}
