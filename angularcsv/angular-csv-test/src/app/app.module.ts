import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { CaseReportComponent } from './case-report/case-report.component';
import { AddCsvDataComponent } from './add-csv-data/add-csv-data.component';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { CovidService } from './covid.service';
import { EditCsvDataComponent } from './edit-csv-data/edit-csv-data.component';


@NgModule({
  declarations: [
    AppComponent,
    CaseReportComponent,
    AddCsvDataComponent,
    EditCsvDataComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,

  ],
  providers: [CovidService],
  bootstrap: [AppComponent]
})
export class AppModule { }
