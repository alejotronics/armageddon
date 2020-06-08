import 'dart:developer';

import 'package:armageddon_app/constants.dart';
import 'package:armageddon_app/models/orderModel.dart';
import 'package:armageddon_app/models/productModel.dart';
import 'package:armageddon_app/models/storeModel.dart';
import 'package:armageddon_app/services/dataGetService.dart';
import 'package:flutter/material.dart';
import 'package:sliding_up_panel/sliding_up_panel.dart';

class ShopScreen extends StatelessWidget {
  final Store store;

  ShopScreen({Key key, @required this.store}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SlidingUpPanel(
        backdropEnabled: true,
        renderPanelSheet: false,
        panel: _floatingPanel(),
        collapsed: _floatingCollapsed(),
        body: Stack(
          fit: StackFit.loose,
          children: <Widget>[
            //Fondo
            new Container(
              width: 450,
              height: 630,
              color: Colors.white,
            ),

            //Container rojo (imagen)
            new Container(
              width: 450,
              height: 225.0,
              color: Colors.redAccent,
            ),
            //Container Lila (Orid)

            Positioned(
              top: 180,
              bottom: 0,
              left: 20,
              right: 20,
              child: new Container(
                  height: 100,
                  decoration: new BoxDecoration(
                      color: PrimaryPurple,
                      borderRadius: new BorderRadius.only(
                          topLeft: const Radius.circular(40.0),
                          topRight: const Radius.circular(40.0))),
                  child: new Column(
                    children: <Widget>[
                      //Productos
                      Padding(
                        padding: const EdgeInsets.only(top: 70, right: 202),
                        child: Text(
                          "Productos",
                          style: new TextStyle(
                            fontSize: 25.0,
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),

                      //lista productos
                      FutureBuilder<List<Product>>(
                          future: getProductsByStoreId(store.id),
                          builder: (context, snapshot) {
                            if (snapshot.connectionState ==
                                ConnectionState.done) {
                              if (snapshot.hasError) {
                                return Text("Error");
                              }

                              Order order = new Order(idTienda: store.id);

                              return Expanded(
                                child: Container(
                                  child: GridView.builder(
                                      gridDelegate:
                                          SliverGridDelegateWithFixedCrossAxisCount(
                                              crossAxisCount: 3),
                                      itemCount: snapshot.data.length,
                                      itemBuilder: (context, index) {
                                        Product product = snapshot.data[index];
                                        return Row(
                                          mainAxisAlignment:
                                              MainAxisAlignment.center,
                                          children: <Widget>[
                                            GestureDetector(
                                              onTap: () {
                                                order.productos.add(new Product(
                                                    id: product.id,
                                                    imgPath: product.imgPath));
                                                SnackBarAction(
                                                  label: product.nombre +
                                                      ' añadido al carrito',
                                                  onPressed: () {},
                                                );
                                                //Add al carrito
                                              },
                                              child: Container(
                                                padding: EdgeInsets.all(0),
                                                decoration: BoxDecoration(
                                                  color: Colors.white,
                                                  borderRadius:
                                                      BorderRadius.circular(17),
                                                ),
                                                child: Image.network(
                                                  product.imgPath,
                                                  height: 90,
                                                  width: 90,
                                                ),
                                              ),
                                            ),
                                          ],
                                        );
                                      }),
                                ),
                              );
                            } else
                              return Center(child: CircularProgressIndicator());
                          }),
                    ],
                  )),
            ),

            //Contaner blanco (info)

            Positioned(
              top: 80,
              left: 45,
              right: 45,
              child: Container(
                  height: 160,
                  decoration: new BoxDecoration(
                      color: Colors.white,
                      borderRadius: new BorderRadius.only(
                        topLeft: const Radius.circular(30.0),
                        topRight: const Radius.circular(30.0),
                        bottomLeft: const Radius.circular(30.0),
                        bottomRight: const Radius.circular(30.0),
                      )),
                  child: new Column(
                    children: <Widget>[
                      //Indormacion tienda
                      Padding(
                        padding: const EdgeInsets.only(top: 15, right: 90),
                        child: Text(
                          store.nombre,
                          style: new TextStyle(
                            fontSize: 20.0,
                            color: Colors.black,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top: 15, right: 185),
                        child: Text(
                          "Datos tienda",
                          style: new TextStyle(
                            fontSize: 15.0,
                            color: Colors.black,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),

                      Padding(
                        padding: const EdgeInsets.only(top: 15, right: 215),
                        child: Text(
                          "Numero",
                          style: new TextStyle(
                            fontSize: 15.0,
                            color: Colors.black,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),

                      Padding(
                        padding: const EdgeInsets.only(top: 15, right: 215),
                        child: Text(
                          "Numero",
                          style: new TextStyle(
                            fontSize: 15.0,
                            color: Colors.black,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),

                      //FIN INFO TIENDA
                    ],
                  )),
            ),
            Positioned(
              top: 43,
              left: 315,
              right: 20,
              child: Container(
                height: 80,
                decoration: new BoxDecoration(
                    color: PrimaryPurple,
                    borderRadius: new BorderRadius.only(
                      topLeft: const Radius.circular(30.0),
                      topRight: const Radius.circular(30.0),
                      bottomLeft: const Radius.circular(30.0),
                      bottomRight: const Radius.circular(30.0),
                    )),
                child: new Column(
                  children: <Widget>[
                    //Indormación tienda
                    Padding(
                      padding: const EdgeInsets.only(top: 13),
                      child: Icon(
                        Icons.favorite,
                        color: Colors.black,
                        size: 55.0,
                      ),
                    ),
                  ],
                ),
              ),
            ),
            Positioned(
              top: 0,
              left: 0,
              child: Padding(
                padding: const EdgeInsets.all(18.0),
                child: IconButton(
                  icon: Icon(Icons.arrow_back),
                  onPressed: () => Navigator.of(context).pop(),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

Widget _floatingCollapsed() {
  return Container(
    decoration: BoxDecoration(
      color: Colors.blueGrey,
      borderRadius: BorderRadius.only(
          topLeft: Radius.circular(24.0), topRight: Radius.circular(24.0)),
    ),
    margin: const EdgeInsets.fromLTRB(24.0, 24.0, 24.0, 0.0),
    child: Center(
      child: Text(
        "This is the collapsed Widget",
        style: TextStyle(color: Colors.white),
      ),
    ),
  );
}

Widget _floatingPanel() {
  return Container(
    decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.all(Radius.circular(24.0)),
        boxShadow: [
          BoxShadow(
            blurRadius: 7.0,
            //color: Colors.white,
          ),
        ]),
    margin: const EdgeInsets.all(24.0),
    child: Center(
      child: Text("PENE"),
    ),
  );
}
