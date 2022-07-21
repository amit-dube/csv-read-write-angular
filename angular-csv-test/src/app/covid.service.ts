import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { OrderDetails } from './model/OrderDetails';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CovidService {
  [x: string]: any;

  /**
    *Http base url
  */
  private apiURL = 'http://localhost/application-test-backend/backend/index.php';


  constructor(private http: HttpClient) { }

  /*
    * To get all the records
  */
    getInfo(): Observable<OrderDetails[]> {
      return this.http.get(`${this.apiURL}/order/list`).pipe<OrderDetails[]>(map((data: any) => data));
    }

  /**
   * To save the details
  */
  addCsvData(Order: OrderDetails): Observable<OrderDetails> {
    return this.http.post<OrderDetails>(`${this.apiURL}/order/add`, Order);
  }

  /**
   * To Edit the details
   */
  editCsvData(Order: OrderDetails): Observable<OrderDetails> {
    return this.http.patch<OrderDetails>(`${this.apiURL}/order/edit?id=${Order.id}`, Order);
  }

  

  /**
	 * To delete the record
	 * id
	*/
  deleteData(id: number): Observable<OrderDetails> {
    return this.http.delete<OrderDetails>(`${this.apiURL}/order/delete?id=${id}`);
  }

}
