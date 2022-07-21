import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddCsvDataComponent } from './add-csv-data/add-csv-data.component';
import { CaseReportComponent } from './case-report/case-report.component';
import { EditCsvDataComponent } from './edit-csv-data/edit-csv-data.component';

const routes: Routes = [
  { path: '', component: CaseReportComponent },
  { path: 'addcsvdata', component: AddCsvDataComponent },
  { path: 'editcsvdata/:id', component: EditCsvDataComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
