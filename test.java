package test;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.RandomAccessFile;
import java.util.Date;

public class A {

    public static void main(String[] g) throws IOException, InterruptedException {

        String s = null;
        String ss = null;
        long pos = 0; // позиция в файле
        int i = 0; // количество строк в файле
        int t = 0; // количество повторений чтения файла
        
        long time = 0;
        
        int m = 3; // используемый метод        
        switch(m) {
            case 1:
                // метод с BufferedReader и readLine
                time = new Date().getTime();
                while (t < 5) {
                    try (BufferedReader reader = new BufferedReader(new InputStreamReader(new FileInputStream("/home/antoxa/Downloads/1/11.log")))) {
                        for (int u = 0; u < i; u++) {
                            reader.readLine();
                        }
                        System.out.println("Начинаем читать файл с " + i + " строки.");
                        while ((s = reader.readLine()) != null) {
                            pos += s.length() + 2; // добавляем символ перевода строки                
                            i++;                
                            ss = s;
                        }
                    }
                    System.out.println("Символов в файле: " + pos);
                    System.out.println("Строк в файле: " + i);
                    System.out.println("Последняя строка в файле:");
                    System.out.println(ss);
//                    Thread.sleep(5 * 1000); // ждем 5 сек
                    t++;
                }
                time = new Date().getTime() - time;
                break;
            case 2:
                // метод с RandomAccessFile       
                time = new Date().getTime();
                RandomAccessFile file = new RandomAccessFile(new File("/home/antoxa/Downloads/1/1.log"), "r");
                while (t < 5) {
                    file.seek(pos);
                    while ((s = file.readLine()) != null) {
                        pos += s.length();
                        i++;
                        ss = s;
                    }
                    System.out.println("Символов в файле: " + pos);
                    System.out.println("Строк в файле: " + i);
                    System.out.println("Последняя строка в файле:");
                    System.out.println(ss);
//                    Thread.sleep(5 * 1000); // ждем 5 сек
                    t++;
                }
                time = new Date().getTime() - time;
                break;
            case 3:
                // комбинированный метод
                time = new Date().getTime();
                while (t < 5) {
                    if (0 == pos) {
                        try (BufferedReader reader = new BufferedReader(new InputStreamReader(new FileInputStream("/home/antoxa/Downloads/1/11.log")))) {
                            while ((s = reader.readLine()) != null) {
                                ss = s;
                                pos += s.length() + 2;
                                i++;
                            }
                        }
                    } else {
                        RandomAccessFile file2 = new RandomAccessFile(new File("/home/antoxa/Downloads/1/11.log"), "r");
                        file2.seek(pos);
                        while ((s = file2.readLine()) != null) {
                            pos += s.length();
                            i++;
                            ss = s;
                        }
                    }
                    System.out.println("Символов в файле: " + pos);
                    System.out.println("Строк в файле: " + i);
                    System.out.println("Последняя строка в файле:");
                    System.out.println(ss);
//                    Thread.sleep(5 * 1000); // ждем 5 сек
                    t++;
                }
                time = new Date().getTime() - time;
                break;
        }
        System.out.println("Метод " + m + " занял " + (time / 1000.) + " милисекунд!");
    }

}
