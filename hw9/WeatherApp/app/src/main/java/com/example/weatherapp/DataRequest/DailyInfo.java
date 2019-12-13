package com.example.weatherapp.DataRequest;

import java.util.Date;

public class DailyInfo {
    private String dailyDate;
    private int weather;
    private Integer minTempret;
    private Integer maxTempret;

    public DailyInfo() {
    }

    public DailyInfo(String dailyDate, int weatherurl, Integer minTempret, Integer maxTempret) {
        this.dailyDate = dailyDate;
        this.weather = weatherurl;
        this.minTempret = minTempret;
        this.maxTempret = maxTempret;
    }


    public String getDailyDate() {
        return dailyDate;
    }

    public void setDailyDate(String dailyDate) {
        this.dailyDate = dailyDate;
    }

    public int getWeather() {
        return weather;
    }

    public void setWeather(int weather) {
        this.weather = weather;
    }

    public Integer getMinTempret() {
        return minTempret;
    }

    public void setMinTempret(Integer minTempret) {
        this.minTempret = minTempret;
    }

    public Integer getMaxTempret() {
        return maxTempret;
    }

    public void setMaxTempret(Integer maxTempret) {
        this.maxTempret = maxTempret;
    }

}
