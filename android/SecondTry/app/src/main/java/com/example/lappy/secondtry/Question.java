package com.example.lappy.secondtry;

import java.util.List;

/**
 * Created by lappy on 5/27/15.
 */
public class Question {
    public String getTitle() {
        return title;
    }

    public String getType() {
        return type;
    }

    public List<String> getMultipleChoiceText() {
        return multipleChoiceText;
    }

    String title;
    String type;
    List<String> multipleChoiceText;

    Question(String title, String type, List<String> multipleChoiceText){
        this.title=title;
        this.type=type;
        this.multipleChoiceText=multipleChoiceText;
    }

    Question(String title, String type){
        this(title,type,null);
    }
}
