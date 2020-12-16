<?

class DB {
                var $HOST = HOST;
                var $UNAME = DBUSER;
                var $PASS = DBPASSWORD;
		var $CONNECTION = 0;
                
                function connect($dbname) {
                        // Connect to MySQL
                        $this->CONNECTION = mysql_connect($this->HOST, $this->UNAME, $this->PASS)
                                or die ("Could not connect to database");
                        // USE Database
                        $result = mysql_select_db($dbname, $this->CONNECTION)
                                or die ("could not select the database");
                }

                function select($queryString) {
                        // SQL SELECT command
                        // returns the result in a 2-dimensional array [int row][assocarray result]
                        // if result is empty count($result) will be 0
						//echo $queryString;
                        $result = mysql_query($queryString,$this->CONNECTION);
			$row_count=mysql_num_rows($result);
                        for ($i=0; $i<$row_count; $i++) {
                                $a = mysql_fetch_array($result,MYSQL_ASSOC);
                                $returnValue[$i] = $a;
                        }
                        return $returnValue;
                }

                function selectID($idname,$queryString) {
                        // SQL SELECT command
                        // returns the result in a 2-dimensional array [resultcolumn $idname][assocarray result]
                        // the column $idname should be a primary key or unique.
                        // if result is empty count($result) will be 0
                        $result = mysql_query($queryString,$this->CONNECTION)
                                or die ("DB: SQL Query not valid!<br>$queryString");
                        for ($i=0; $i<mysql_num_rows($result); $i++) {
                                $a = mysql_fetch_array($result,MYSQL_ASSOC)
                                        or die ("DB: Could not fetch data!");
                                $returnValue[$a[$idname]] = $a;
                        }
                        return $returnValue;
                }

                function query($queryString) {
                        // for SQL insert, delete, update and replace command
                        // returns the number of affected rows
                        $result = mysql_query($queryString,$this->CONNECTION)
                                or die ("DB: SQL Query not valid!<br>$queryString");
                        return mysql_affected_rows($this->CONNECTION);
                }

                function getLastInsertID() {
                        // returns the last inserted auto_increment id
                        return mysql_insert_id($this->CONNECTION);
                }

                function getTableFields($table) {
                        // returns the names of fields in table $table in an array[number]["Field"] = fieldname
                        return $this->select("show fields from $table");
                }
                
                # Pager for navigation in VoIPonCD
                function pager($current_page, $records_per_page, $pages_per_pageList, $dataQuery, $countQuery){
                  $obj->record             = array();  // beinhaltet ein Arrray des objects mit Daten wor&uuml;ber dann zugegriffen wird.
                  $obj->current_page       = $current_page; // Startet mit 0!
                  $obj->total_cur_page     = 0;        // shows how many records belong to current page
                  $obj->records_per_page   = 0;
                  $obj->total_records      = 0;
                  $obj->total_pages        = 0;
                  $obj->preceding          = false;    // Ist true wenn es eine Seite vor der angezeigten gibt.
                  $obj->subsequent         = false;    // Ist true wenn es eine Seite nach der angezeigten gibt.
                  $obj->pages_per_pageList = 10;        //$pages_per_pageList;
                  $result=mysql_query($countQuery, $this->CONNECTION);
                  $obj->total_records      = mysql_num_rows($result);
                  if($obj->total_records>0){
                    $obj->record                  = $this->select($dataQuery);
                    $obj->total_cur_page          = sizeof($obj->record);
                    $obj->records_per_page        = $records_per_page;
                    $obj->total_pages             = ceil($obj->total_records/$records_per_page);
                    $obj->offset_page             = $obj->pages_per_pageList*floor($obj->current_page/$obj->pages_per_pageList);
                    $obj->total_pages_in_pageList = $obj->total_pages-($obj->offset_page+$obj->pages_per_pageList);
                    $obj->last_page_in_pageList   = $obj->offset_page+$obj->pages_per_pageList;
                    if($obj->last_page_in_pageList>$obj->total_pages) $obj->last_page_in_pageList=$obj->total_pages;
                    if($obj->offset_page>0) $obj->pageList_preceding=true;
                    else $obj->pageList_preceding=false;
                    if($obj->last_page_in_pageList<$obj->total_pages) $obj->pageList_subsequent=true;
                    else $obj->pageList_subsequent=false;
                    if($obj->current_page>1) $obj->preceding=true;
                    if($obj->current_page<$obj->total_pages) $obj->subsequent=true;
                  }
                  return $obj;
                }
				
				function closeDb()
				{
					mysql_close ($this->CONNECTION);
				}	

        }

?>
