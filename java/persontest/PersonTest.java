class Person {
  String name;
  int age;
  String address;

  Person(String _name, int _age, String _address) {
    name = _name;
    age = _age;
    address = _address;
  }
  void say(){
    System.out.println("„‚Ì–¼‘O‚Í" + name + "‚Å‚·B”N—î‚Í" 
    + age + "Ë‚ÅAZŠ‚Í" + address + "‚Å‚·B");
  }

}

class PersonTest {
  public static void main(String[] args) {
    Person taro = new Person("‘¾˜Y", 21, "“Œ‹“s`‹æ");
    taro.say();

    Person hanako = new Person("‰Ôq", 18, "–kŠC“¹D–ys");
    hanako.say();
  }
}



