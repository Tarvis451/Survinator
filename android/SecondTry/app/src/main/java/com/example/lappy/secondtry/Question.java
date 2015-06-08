package com.example.lappy.secondtry;

import java.util.List;

/**
 * Created by lappy on 5/27/15.
 */
public class Question {
    String title;
    int type;
    List<String> multipleChoiceText;

    Question(String title, int type, List<String> multipleChoiceText){
        this.title=title;
        this.type=type;
        this.multipleChoiceText=multipleChoiceText;
    }

    Question(String title, int type){
        this(title,type,null);
    }
}
