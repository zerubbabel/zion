## new_customer_order
add order:
	add:sale_order_mst,sale_order_dtl
delete order: 仅当该单还未产生任何相关业务(没有对应的出库单或out数据为0)
	delete:sale_order_mst,sale_order_dtl
update order: 仅当该单还未产生任何相关业务(没有对应的出库单)
	del & insert:sale_order_mst,sale_order_dtl

## customer_order_out
add out:	
	add:customer_order_out_mst,customer_order_out_dtl
	update:sale_order_dtl(out+=qty),sale_order_mst(DONE)

以下两个操作待定，或者权限交给更高级的操作者，否则影响太深远
delete out:
	delete:customer_out_dtl,customer_out_dtl
	update or add if record not exist:customer_product
	update:sale_order_mst(DONE to not DONE)		

update out:
	update:customer_out_dtl,customer_out_dtl，sale_order_mst(DONE or not Done)
	update or del if qty=0 or add if not exist:customer_product
	
## tasks
view：
查看待生产的产品，依交货日期升序排列(一周以内红色)


## 2018.3.31
### todo
1.customer_order print
2.tasks by customer