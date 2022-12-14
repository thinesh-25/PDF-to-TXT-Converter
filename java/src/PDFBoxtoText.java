import java.io.IOException;
import java.util.Formatter;
import java.util.Scanner;
import java.io.File;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
import org.apache.pdfbox.Loader; 
import org.apache.commons.io.FilenameUtils;

public class PDFBoxtoText{
    public static void main(String[] args) throws IOException{ 
        File folder;
        folder = new File("java/retrieval.txt");                    //To open the file with converted text format 
        Scanner scanner;
        scanner = new Scanner(folder);
        String filename;
        filename = scanner.nextLine();
	    scanner.close();

        File pdfFile;
        pdfFile = new File("java/upload/"+filename);                //To open pdf file
        String pdfname;
        pdfname = FilenameUtils.getBaseName(pdfFile.getName());     //To get pdf file name
            
        try(PDDocument doc = Loader.loadPDF(pdfFile)){              //To parse the pdf file
            PDFTextStripper stripfile;
            stripfile= new PDFTextStripper();                        //To strip text without formatting 
            String text;
            text = stripfile.getText(doc);
            
            Formatter textFile = new Formatter("java/text/" + pdfname + ".txt");    //To create a txt file when pdf file is received
            textFile.format(text);                                  //To write text into file
            textFile.close();                                       //To close file
            Formatter file = new Formatter("java/retrieval.txt");   //To open the retrieval.txt
            file.format(pdfname + ".txt");                          //To write the converted pdf file name with .txt format
            file.close();                                           //To close the file
        }
    }
}
